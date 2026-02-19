<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clinics', function (Blueprint $table) {
            $table->string('customer_id')->nullable()->unique();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->date('exp_date')->nullable();
            $table->date('first_warning_date')->nullable();
            $table->date('second_warning_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('clinics', function (Blueprint $table) {
            $table->dropColumn([
                'customer_id', 'address_line_1', 'address_line_2', 'country', 
                'state', 'zip_code', 'exp_date', 'first_warning_date', 'second_warning_date'
            ]);
        });
    }
};