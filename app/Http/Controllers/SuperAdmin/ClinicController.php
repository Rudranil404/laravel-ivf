<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Mpdf\Laravel\Facade as PDF;


    
class ClinicController extends Controller
{
    public function index()
    {
        $clinics = Clinic::with(['branches', 'contacts', 'users'])->latest()->get();
        return view('superadmin.clinics.index', compact('clinics'));
    }

    // NEW: Show method to view a specific clinic
    public function show($id)
    {
        $clinic = Clinic::with(['branches.contacts', 'contacts', 'users'])->findOrFail($id);
        return view('superadmin.clinics.show', compact('clinic'));
    }

    public function update(Request $request, $id)
    {
        $clinic = Clinic::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clinics,email,' . $clinic->id,
            'max_branches' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
        ]);

        DB::beginTransaction();

        try {
            $clinic->update([
                'name' => $request->name,
                'email' => $request->email,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'country' => $request->country,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'max_branches' => $request->max_branches,
                'is_active' => $request->is_active,
                'exp_date' => $request->exp_date,
                'first_warning_date' => $request->first_warning_date,
                'second_warning_date' => $request->second_warning_date,
            ]);

            // Sync Contacts (Simple approach: delete old and re-add)
            if ($request->has('contacts')) {
                $clinic->contacts()->delete();
                foreach ($request->contacts as $contact) {
                    if (!empty($contact['phone'])) {
                        $clinic->contacts()->create($contact);
                    }
                }
            }

            DB::commit();
            return redirect()->route('superadmin.clinics.index')->with('success', 'Clinic updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Update failed: ' . $e->getMessage()]);
        }
    }
    public function print($id)
    {
        $clinic = Clinic::with(['branches.contacts', 'contacts', 'users'])->findOrFail($id);

        // This package uses the same loadView method
        $pdf = PDF::loadView('superadmin.clinics.print', ['clinic' => $clinic]);

        return $pdf->stream($clinic->customer_id . '_details.pdf');
    }

    public function store(Request $request)
    {
        $request->validate([
            'clinic_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:8|confirmed',
            'max_branches' => 'required|integer|min:0',
            'amc_status' => 'required|boolean',
        ]);

        DB::beginTransaction();

        try {
            $clinic = Clinic::create([
                'name' => $request->clinic_name,
                'email' => $request->admin_email,
                'customer_id' => 'CUST-' . strtoupper(uniqid()),
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'country' => $request->country,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'max_branches' => $request->max_branches,
                'is_active' => $request->amc_status,
                'exp_date' => $request->exp_date,
                'first_warning_date' => $request->first_warning_date,
                'second_warning_date' => $request->second_warning_date,
            ]);

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

            if ($request->has_branch == '1') {
                $branch = $clinic->branches()->create([
                    'branch_cust_id' => 'BR-' . strtoupper(uniqid()),
                    'name' => $request->branch_name,
                    'address_line_1' => $request->branch_address_line_1,
                    'address_line_2' => $request->branch_address_line_2,
                    'country' => $request->branch_country,
                    'state' => $request->branch_state,
                    'zip_code' => $request->branch_zip_code,
                ]);

                if ($request->has('branch_contacts')) {
                    foreach ($request->branch_contacts as $bContact) {
                        if (!empty($bContact['phone'])) {
                            $branch->contacts()->create([
                                'name' => $bContact['name'] ?? 'Primary',
                                'position' => $bContact['position'] ?? 'General',
                                'phone' => $bContact['phone'],
                            ]);
                        }
                    }
                }
            }

            $clinicAdmin = User::create([
                'name' => 'Clinic Admin',
                'email' => $request->admin_email,
                'password' => Hash::make($request->admin_password),
                'clinic_id' => $clinic->id,
            ]);

            $role = Role::firstOrCreate(['name' => 'Clinic Admin', 'guard_name' => 'web']);
            $clinicAdmin->assignRole($role);

            DB::commit();

            return redirect()->back()->with('success', 'Clinic successfully registered.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }
    
}