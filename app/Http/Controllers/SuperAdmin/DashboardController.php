<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Core Clinic & User Statistics
        $totalClinics = Clinic::count();
        $activeClinics = Clinic::where('is_active', true)->count();
        $totalUsers = User::count();

        // 2. Fetch all clinics with user counts
        $clinics = Clinic::withCount('users')->latest()->get();

        // 3. Simulated Financial Data (To be replaced with real DB queries in Step 4)
        $financials = [
            'total_revenue' => 1245000,   // e.g., $1,245,000
            'monthly_growth' => 14.5,     // 14.5% up
            'active_subscriptions' => $activeClinics,
            'pending_dues' => 45000,      // e.g., $45,000
        ];

        // Adding mock revenue to each clinic for the informative UI table
        foreach ($clinics as $clinic) {
            $clinic->monthly_revenue = rand(15000, 85000); // Random mock revenue per clinic
        }

        return view('superadmin.dashboard', compact(
            'totalClinics', 
            'activeClinics', 
            'totalUsers', 
            'clinics',
            'financials'
        ));
    }
}