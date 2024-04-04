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
        Schema::table('appointments', function (Blueprint $table) {
            // Change the column types to unsignedBigInteger
            $table->unsignedBigInteger('patient_id')->change();
            $table->unsignedBigInteger('doctor_id')->change();

            // Add foreign key constraints
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Drop the foreign key constraints
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['doctor_id']);

            // Change the column types back to integer if needed
            $table->integer('patient_id')->change();
            $table->integer('doctor_id')->change();
        });
    }
};
