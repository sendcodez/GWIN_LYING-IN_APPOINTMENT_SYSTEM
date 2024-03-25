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
        Schema::create('pregnancy_terms', function (Blueprint $table) {
           
            $table->id();
            $table->integer('patient_id'); 
            $table->string('gravida')->nullable();
            $table->string('para')->nullable();
            $table->string('t')->nullable();
            $table->string('p')->nullable();
            $table->string('a')->nullable();
            $table->string('l')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
