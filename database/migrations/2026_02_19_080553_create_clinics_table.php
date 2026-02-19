<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create the clinics table
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->integer('max_branches')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Add the clinic_id foreign key to the users table AFTER clinics exists
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('clinic_id')->nullable()->constrained('clinics')->nullOnDelete();
        });
    }

    public function down(): void
    {
        // Drop the foreign key first, then the table
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['clinic_id']);
            $table->dropColumn('clinic_id');
        });
        
        Schema::dropIfExists('clinics');
    }
};