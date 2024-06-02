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
        Schema::create('newborn', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('card');
            $table->string('baby_lastname');
            $table->string('mother_lastname');
            $table->string('mother_firstname');
            $table->string('birthday');
            $table->string('birthtime');
            $table->string('date_collection');
            $table->string('time_collection');
            $table->string('weight');
            $table->string('sex');
            $table->string('aog');
            $table->string('feeding');
            $table->string('status');
            $table->string('birthplace');
            $table->string('address');
            $table->string('contact');
            $table->string('blood_collector');
            $table->string('staff');
            $table->string('result_received');
            $table->string('result');
            $table->string('date_claimed');
            $table->string('claimed_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newborn');
    }
};
