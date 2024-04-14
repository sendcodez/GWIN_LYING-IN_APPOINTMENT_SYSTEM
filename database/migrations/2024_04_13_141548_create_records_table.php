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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->string('patient_name');
            $table->string('date')->nullable();
            $table->string('aog')->nullable();
            $table->string('chief')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('weight')->nullable();
            $table->string('temperature')->nullable();
            $table->string('cardiac')->nullable();
            $table->string('respiratory')->nullable();
            $table->string('fundic')->nullable();
            $table->string('fht')->nullable();
            $table->string('ie')->nullable();
            $table->string('diagnosis')->nullable();
            $table->string('follow_up')->nullable();
            $table->string('plan')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
