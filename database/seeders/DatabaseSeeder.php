<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create the necessary Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $clinicAdminRole = Role::firstOrCreate(['name' => 'Clinic Admin', 'guard_name' => 'web']);
        
        // 2. Create the Super Admin User in MySQL
        $superAdmin = User::firstOrCreate(
            ['email' => 'super@admin.com'], // Check if email exists
            [
                'name' => 'System Super Admin',
                'password' => Hash::make('password'), // This hashes the password for MySQL
                'email_verified_at' => now(),
            ]
        );

        // 3. Assign the Super Admin role to this user
        $superAdmin->assignRole($superAdminRole);
        
        $this->command->info('Super Admin user created successfully!');
        $this->command->info('Email: super@admin.com');
        $this->command->info('Password: password');
    }
}