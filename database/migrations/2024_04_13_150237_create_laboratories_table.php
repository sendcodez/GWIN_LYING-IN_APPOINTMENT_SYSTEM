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
        Schema::create('laboratories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('patient_name');
            $table->string('date')->nullable();
            $table->string('urinalysis')->nullable();
            $table->string('cbc')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('hbsag')->nullable();
            $table->string('vdrl')->nullable();
            $table->string('fbs')->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratories');
    }
};
