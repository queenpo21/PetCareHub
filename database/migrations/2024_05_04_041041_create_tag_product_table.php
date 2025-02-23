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
        Schema::create('tagProduct', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->integer('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->integer('tag_id')->references('id')->on('tag')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagProduct');
    }
};
