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
        Schema::create('patients', function (Blueprint $table) {
         
            $table->id();
            $table->integer('user_id'); 
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('maiden')->nullable();
            $table->string('birthplace');
            $table->string('birthday');
            $table->integer('age');
            $table->string('civil');
            $table->string('contact_number')->nullable();
            $table->string('religion');
            $table->string('occupation')->nullable();
            $table->string('nationality');
            $table->string('husband_firstname');
            $table->string('husband_middlename')->nullable();
            $table->string('husband_lastname');
            $table->string('husband_occupation')->nullable();
            $table->string('husband_birthday');
            $table->integer('husband_age');
            $table->string('husband_contact_number')->nullable();
            $table->string('husband_religion');
            $table->string('province');
            $table->string('city');
            $table->string('barangay');
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
