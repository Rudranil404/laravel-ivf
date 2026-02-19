<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PasswordController extends Controller
{
    // 1. Show the simple Change Password form
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    // 2. Verify current password and save the new one
    public function updateCurrentPassword(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'], // Confirmed expects 'new_password_confirmation'
        ]);

        // Check if the typed current password matches the one in the database
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
        }

        // Update the password
        auth()->user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Redirect back to their dashboard (Checks role to send them to the right place)
        $route = auth()->user()->hasRole('Super Admin') ? 'superadmin.dashboard' : 'login';
        
        return redirect()->route($route)->with('success', 'Your password has been changed successfully!');
    }
}