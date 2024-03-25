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
        Schema::table('pregnancy_terms', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_id')->change(); // Change the column to unsignedBigInteger if needed
        
            // Add foreign key constraint
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
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
