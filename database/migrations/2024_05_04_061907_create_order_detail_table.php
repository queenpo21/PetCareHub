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
        Schema::create('orderDetail', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->integer('order_id')->references('id')->on('order')->onDelete('cascade');
            $table->integer('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->string('size');
            $table->integer('price');
            $table->integer('num');
            $table->enum('rating', ['1','2','3','4','5'])->default(5);
            $table->text('feedback')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderDetail');
    }
};
