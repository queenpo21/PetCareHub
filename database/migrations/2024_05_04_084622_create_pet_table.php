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
        Schema::create('pet', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->enum('pet_type',['Chó', 'Mèo']);
            $table->string('pet_number');
            $table->string('name');
            $table->string('breed');
            $table->double('age');
            $table->double('weight');
            $table->text('medical_history');
            $table->integer('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet');
    }
};
