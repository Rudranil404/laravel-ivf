<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\ClinicController;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->hasRole('Super Admin')) return redirect()->route('superadmin.dashboard');
        if ($user->hasRole('Clinic Admin')) return redirect()->route('clinic.dashboard');
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        
        Route::get('/change-password', [PasswordController::class, 'showChangePasswordForm'])->name('password.change');
        Route::post('/change-password', [PasswordController::class, 'updateCurrentPassword'])->name('password.update.current');
        
        // --- SUPER ADMIN ROUTES ---
        Route::middleware(['auth', 'role:Super Admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Core Organization/Clinic routes
        Route::get('/clinics', [ClinicController::class, 'index'])->name('clinics.index');
        Route::post('/clinics', [ClinicController::class, 'store'])->name('clinics.store');
        Route::get('/clinics/{clinic}', [ClinicController::class, 'show'])->name('clinics.show');
        Route::put('/clinics/{clinic}', [ClinicController::class, 'update'])->name('clinics.update');

        // Branch specific actions (Edit, Toggle Status, Delete)
        Route::put('/clinics/{clinic}', [ClinicController::class, 'update'])->name('clinics.update');
        Route::put('/clinics/{clinic}/toggle-status', [ClinicController::class, 'toggleStatus'])->name('clinics.toggle-status');
        Route::delete('/clinics/{clinic}', [ClinicController::class, 'destroy'])->name('clinics.destroy');
        Route::put('/clinics/{clinic}/mrn', [ClinicController::class, 'updateMrn'])->name('clinics.update-mrn'); // <-- NEW MRN ROUTE
            
        // NEW: Organization Action Routes
        Route::put('/organizations/{organization}', [ClinicController::class, 'updateOrg'])->name('organizations.update');
        Route::delete('/organizations/{organization}', [ClinicController::class, 'destroyOrg'])->name('organizations.destroy');
        Route::post('/organizations/{organization}/branches', [ClinicController::class, 'storeBranch'])->name('organizations.branches.store');
        Route::post('/organizations/{organization}/admins', [ClinicController::class, 'storeAdmin'])->name('organizations.admins.store');
    });

    // --- CLINIC ADMIN ROUTES ---
    Route::middleware(['role:Clinic Admin'])->prefix('clinic')->name('clinic.')->group(function () {
        Route::get('/dashboard', function() { return 'Clinic Admin Dashboard'; })->name('dashboard');
    });

    Route::get('/user/dashboard', function() { return 'Clinic User Dashboard'; })->name('user.dashboard');
});