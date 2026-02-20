<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Clinic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
// Using the auto-discovery alias or the direct namespace
use PDF;

class ClinicController extends Controller
{
    /**
     * Display a listing of Organizations and their branches.
     */
    public function index()
    {
        $organizations = Organization::with(['clinics.contacts', 'mainBranch'])->latest()->get();
        return view('superadmin.clinics.index', compact('organizations'));
    }

    /**
     * Show method to view a specific clinic/branch.
     */
    public function show($id)
    {
        $clinic = Clinic::with(['branches.contacts', 'contacts', 'users', 'organization'])->findOrFail($id);
        return view('superadmin.clinics.show', compact('clinic'));
    }

    /**
     * 1. STORE ORG & HUB
     */
    public function store(Request $request)
    {
        $request->validate([
            'org_name' => 'required|string|max:255',
            'clinic_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:8|confirmed',
            'hub_exp_date' => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            // Create the Group (Organization)
            $org = Organization::create([
                'org_name' => $request->org_name,
                'org_cust_id' => 'ORG-' . strtoupper(uniqid()),
                'hq_email' => $request->admin_email,
                'website' => $request->website,
            ]);

            // Save ID and Password in the Clinic Table for the Hub
            $clinic = $org->clinics()->create([
                'name' => $request->clinic_name,
                'email' => $request->admin_email,
                'admin_email' => $request->admin_email,       // <-- Saved to clinic table
                'admin_password' => $request->admin_password, // <-- Saved to clinic table
                'is_main_branch' => true,
                'customer_id' => 'HUB-' . strtoupper(uniqid()),
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'country' => $request->country,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'max_branches' => $request->max_branches ?? 5,
                'is_active' => true, 
                'exp_date' => $request->hub_exp_date,
                'first_warning_date' => $request->first_warning_date,
                'second_warning_date' => $request->second_warning_date,
            ]);

            // Add Clinic Contacts if provided (Dynamic array)
            if ($request->has('clinic_contacts')) {
                foreach ($request->clinic_contacts as $contact) {
                    if (!empty($contact['phone'])) {
                        $clinic->contacts()->create([
                            'name' => $contact['name'] ?? 'Primary',
                            'position' => $contact['position'] ?? 'General',
                            'phone' => $contact['phone'],
                        ]);
                    }
                }
            }

            // Create the Admin User for this Clinic
            $clinicAdmin = User::create([
                'name' => 'Group Admin',
                'email' => $request->admin_email,
                'password' => Hash::make($request->admin_password),
                'clinic_id' => $clinic->id,
            ]);

            $role = Role::firstOrCreate(['name' => 'Clinic Admin', 'guard_name' => 'web']);
            $clinicAdmin->assignRole($role);

            DB::commit();
            return redirect()->back()->with('success', 'Group and Main Hub successfully registered.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Update an existing clinic/branch details.
     */
    public function update(Request $request, $id)
    {
        $clinic = Clinic::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'exp_date' => 'required|date',
            'email' => 'nullable|email'
        ]);

        DB::beginTransaction();

        try {
            $clinic->update([
                'name' => $request->name,
                'email' => $request->email ?? $clinic->email, 
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'country' => $request->country,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'max_branches' => $request->max_branches ?? $clinic->max_branches,
                'exp_date' => $request->exp_date,
            ]);

            if ($request->filled('branch_phone')) {
                $contact = $clinic->contacts()->first();
                if ($contact) {
                    $contact->update(['phone' => $request->branch_phone]);
                } else {
                    $clinic->contacts()->create([
                        'name' => 'Branch Contact',
                        'position' => 'Reception',
                        'phone' => $request->branch_phone,
                    ]);
                }
            }

            if ($request->has('contacts') && is_array($request->contacts)) {
                $clinic->contacts()->delete();
                foreach ($request->contacts as $contact) {
                    if (!empty($contact['phone'])) {
                        $clinic->contacts()->create($contact);
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Branch details updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Update failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Toggle Active/Inactive status for a branch
     */
    public function toggleStatus($id)
    {
        $clinic = Clinic::findOrFail($id);
        $clinic->update(['is_active' => !$clinic->is_active]);
        
        $status = $clinic->is_active ? 'Activated' : 'Suspended';
        return redirect()->back()->with('success', "Branch has been {$status}.");
    }

    /**
     * Update MRN Prefix for a branch
     */
    public function updateMrn(Request $request, $id)
    {
        $request->validate(['mrn_prefix' => 'nullable|string|max:50']);
        $clinic = Clinic::findOrFail($id);
        
        $prefix = $request->mrn_prefix ? strtoupper(trim($request->mrn_prefix)) : null;
        $clinic->update(['mrn_prefix' => $prefix]);
        
        return redirect()->back()->with('success', 'MRN Prefix saved successfully.');
    }

    /**
     * Delete an individual branch (Prevents deleting the Hub)
     */
    public function destroy($id)
    {
        $clinic = Clinic::findOrFail($id);

        if ($clinic->is_main_branch) {
            return redirect()->back()->withErrors(['error' => 'Cannot delete Hub independently. You must delete the entire Organization.']);
        }

        $clinic->delete(); // This triggers the model event and deletes the users too!
        return redirect()->back()->with('success', 'Branch and related users successfully deleted.');
    }

    // --- ORGANIZATION SPECIFIC ACTIONS ---

    // Edit Organization Name
    public function updateOrg(Request $request, $id)
    {
        $request->validate(['org_name' => 'required|string|max:255']);
        $org = Organization::findOrFail($id);
        $org->update(['org_name' => $request->org_name]);
        return redirect()->back()->with('success', 'Organization updated successfully.');
    }

    // Delete Organization (Cascades and deletes all branches and users)
    public function destroyOrg($id)
    {
        $org = Organization::findOrFail($id);
        $org->delete(); // Triggers cascade down to clinics and then down to users!
        return redirect()->back()->with('success', 'Organization, all branches, and all user accounts deleted.');
    }

    // 2. STORE SUB-BRANCH
    public function storeBranch(Request $request, $id)
    {
        $request->validate([
            'clinic_name' => 'required|string|max:255',
            'address_line_1' => 'required|string',
            'branch_email' => 'nullable|email|unique:users,email',
            'branch_password' => 'nullable|string|min:6',
            'exp_date' => 'required|date',
        ]);

        $org = Organization::findOrFail($id);
        $branchId = 'SUB-' . strtoupper(uniqid());

        // Save ID and Password in the Clinic Table
        $branch = $org->clinics()->create([
            'name' => $request->clinic_name,
            'is_main_branch' => false,
            'customer_id' => $branchId,
            'email' => $request->branch_email ?? strtolower($branchId) . '@system.local',
            'admin_email' => $request->branch_email,       // <-- Saved to clinic
            'admin_password' => $request->branch_password, // <-- Saved to clinic
            'address_line_1' => $request->address_line_1,
            'state' => $request->state,
            'country' => $request->country,
            'zip_code' => $request->zip_code,
            'exp_date' => $request->exp_date,
            'is_active' => true,
        ]);

        if ($request->filled('branch_phone')) {
            $branch->contacts()->create([
                'name' => 'Branch Contact',
                'position' => 'Reception',
                'phone' => $request->branch_phone,
            ]);
        }

        // If Email & Password provided, create actual User Login for this branch
        if ($request->filled('branch_email') && $request->filled('branch_password')) {
            $user = User::create([
                'name' => $request->clinic_name . ' Admin',
                'email' => $request->branch_email,
                'password' => Hash::make($request->branch_password),
                'clinic_id' => $branch->id,
            ]);
            $user->assignRole('Clinic Admin');
        }

        return redirect()->back()->with('success', 'Sub-Branch added successfully.');
    }

    // Create an Admin for the Organization
    public function storeAdmin(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $org = Organization::with('mainBranch')->findOrFail($id);

        if (!$org->mainBranch) {
            return back()->withErrors(['error' => 'No main branch found for this organization to attach the admin to.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'clinic_id' => $org->mainBranch->id,
        ]);

        $user->assignRole('Clinic Admin');

        return redirect()->back()->with('success', 'Admin created successfully.');
    }

    /**
     * Generate PDF for a specific clinic.
     */
    public function print($id)
    {
        $clinic = Clinic::with(['branches.contacts', 'contacts', 'users', 'organization'])->findOrFail($id);
        $pdf = PDF::loadView('superadmin.clinics.print', ['clinic' => $clinic]);
        
        return $pdf->stream($clinic->customer_id . '_details.pdf');
    }
}