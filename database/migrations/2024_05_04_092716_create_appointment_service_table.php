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
        Schema::create('appointmentService', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->integer('appointment_id')->references('id')->on('appointment')->onDelete('cascade');
            $table->integer('service_id')->references('id')->on('service')->onDelete('cascade');
            $table->integer('cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointmentService');
    }
};
