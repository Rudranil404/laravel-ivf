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
    Route::middleware(['role:Super Admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/clinics', [ClinicController::class, 'index'])->name('clinics.index');
        Route::post('/clinics', [ClinicController::class, 'store'])->name('clinics.store');
        Route::get('/clinics/{clinic}', [ClinicController::class, 'show'])->name('clinics.show'); // NEW ROUTE
        Route::put('/clinics/{clinic}', [ClinicController::class, 'update'])->name('clinics.update');
        Route::get('/clinics/{clinic}/print', [ClinicController::class, 'print'])->name('clinics.print');
    });

    // --- CLINIC ADMIN ROUTES ---
    Route::middleware(['role:Clinic Admin'])->prefix('clinic')->name('clinic.')->group(function () {
        Route::get('/dashboard', function() { return 'Clinic Admin Dashboard'; })->name('dashboard');
    });

    Route::get('/user/dashboard', function() { return 'Clinic User Dashboard'; })->name('user.dashboard');
});