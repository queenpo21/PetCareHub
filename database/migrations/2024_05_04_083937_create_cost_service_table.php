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
        Schema::create('costService', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->enum('type',['Cắt tỉa', 'Khách sạn']);
            $table->enum('pet_type',['Chó', 'Mèo']);
            $table->integer('service_id')->references('id')->on('service')->onDelete('cascade');
            $table->string('pack_service');
            $table->double('minkg');
            $table->double('maxkg');
            $table->double('cost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costService');
    }
};
