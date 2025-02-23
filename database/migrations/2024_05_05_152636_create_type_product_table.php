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
        Schema::create('typeProduct', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->string('name')-> unique;
            $table->string('category_name')->references('name')->on('category')->onDelete('set null');
            $table->integer('category_id')->references('id')->on('category')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('typeProduct');
    }
};
