<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\ClinicController;

// Smart Root Route
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->hasRole('Super Admin')) return redirect()->route('superadmin.dashboard');
        if ($user->hasRole('Clinic Admin')) return redirect()->route('clinic.dashboard');
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
});

// Public Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Authenticated Routes (Must be logged in)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // --- SIMPLE CHANGE PASSWORD ROUTES ---
    Route::get('/change-password', [PasswordController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [PasswordController::class, 'updateCurrentPassword'])->name('password.update.current');
    
    // --- SUPER ADMIN ROUTES ---
    Route::middleware(['role:Super Admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Clinic Management Routes (Index handles the list & modal, Store handles the save)
        Route::get('/clinics', [ClinicController::class, 'index'])->name('clinics.index');
        Route::post('/clinics', [ClinicController::class, 'store'])->name('clinics.store');
    });

    // --- CLINIC ADMIN ROUTES ---
    Route::middleware(['role:Clinic Admin'])->prefix('clinic')->name('clinic.')->group(function () {
        Route::get('/dashboard', function() { return 'Clinic Admin Dashboard'; })->name('dashboard');
    });

    // --- CLINIC USER ROUTES ---
    Route::get('/user/dashboard', function() { return 'Clinic User Dashboard'; })->name('user.dashboard');
});