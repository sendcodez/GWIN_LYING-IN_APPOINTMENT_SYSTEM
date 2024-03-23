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
        Schema::create('medical_histories', function (Blueprint $table) {
           
            $table->id();
            $table->integer('patient_id'); 
            $table->boolean('hypertension')->default(false);
            $table->boolean('heartdisease')->default(false);
            $table->boolean('asthma')->default(false);
            $table->boolean('tuberculosis')->default(false);
            $table->boolean('diabetes')->default(false);
            $table->boolean('goiter')->default(false);
            $table->boolean('epilepsy')->default(false);
            $table->boolean('allergy')->default(false);
            $table->boolean('hepatitis')->default(false);
            $table->boolean('vdrl')->default(false);
            $table->boolean('bleeding')->default(false);
            $table->boolean('operation')->default(false);
            $table->string('others')->nullable();
            $table->string('tt1')->nullable();
            $table->string('tt2')->nullable();
            $table->string('tt3')->nullable();
            $table->string('tt4')->nullable();
            $table->string('tt5')->nullable();
            $table->rememberToken();
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
