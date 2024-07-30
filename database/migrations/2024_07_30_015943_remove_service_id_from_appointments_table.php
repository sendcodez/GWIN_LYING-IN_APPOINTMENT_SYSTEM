<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['service_id']);

            // Drop the service_id column
            $table->dropColumn('service_id');
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Recreate the service_id column
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
        });
    }
};
