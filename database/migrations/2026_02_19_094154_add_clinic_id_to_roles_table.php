<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // 1. Drop Spatie's default global unique constraint
            $table->dropUnique('roles_name_guard_name_unique');
            
            // 2. Add the clinic_id column
            $table->foreignId('clinic_id')->nullable()->constrained('clinics')->cascadeOnDelete();
            
            // 3. Create a new unique constraint: Name + Guard + Clinic
            $table->unique(['name', 'guard_name', 'clinic_id']);
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropUnique(['name', 'guard_name', 'clinic_id']);
            $table->dropForeign(['clinic_id']);
            $table->dropColumn('clinic_id');
            $table->unique(['name', 'guard_name'], 'roles_name_guard_name_unique');
        });
    }
};