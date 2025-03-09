<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->boolean('referral')->default(0);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('gender', ['Male', 'Female'])->after('usertype')->nullable();
        });
    
        Schema::table('doctors', function (Blueprint $table) {
            $table->enum('gender', ['Male', 'Female'])->after('expertise')->nullable();
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->boolean('referral')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
