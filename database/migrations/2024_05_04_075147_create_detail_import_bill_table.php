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
        Schema::create('detailImportBill', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->integer('bill_id')->references('id')->on('bill')->onDelete('cascade');
            $table->integer('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->integer('num');
            $table->float('price');
            $table->float('total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailImportBill');
    }
};
