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
        Schema::create('delivery', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('birthday');
            $table->string('birthtime');
            $table->string('sex');
            $table->string('weight');
            $table->string('hc');
            $table->string('cc');
            $table->string('ac');
            $table->string('bl');
            $table->string('birth_order');
            $table->string('aog');
            $table->string('hepa');
            $table->string('bcg');
            $table->string('nbs');
            $table->string('hearing');
            $table->string('handle');
            $table->string('assist');
            $table->string('referral');

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
        Schema::dropIfExists('delivery');
    }
};
