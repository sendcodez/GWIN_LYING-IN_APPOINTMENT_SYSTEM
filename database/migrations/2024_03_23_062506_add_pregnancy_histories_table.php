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
        Schema::create('pregnancy_histories', function (Blueprint $table) {
           
            $table->id();
            $table->integer('user_id'); 
            $table->integer('pregnancy')->nullable();
            $table->date('pregnancy_date')->nullable();
            $table->string('aog')->nullable();
            $table->string('manner')->nullable();
            $table->string('bw')->nullable();
            $table->enum('sex', ['male', 'female'])->nullable();
            $table->string('present_status')->nullable();
            $table->string('complications')->nullable();
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
