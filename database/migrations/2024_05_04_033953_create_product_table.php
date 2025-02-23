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
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->string('name')->unique;
            $table->string('typeProduct_name')->references('name')->on('typeProduct')->onDelete('set null');
            $table->integer('typeProduct_id')->references('id')->on('typeProduct')->onDelete('set null');
            $table->integer('min_price')->default(0);
            $table->integer('max_price')->default(0);
            $table->integer('discount_price')->nullable();
            $table->integer('inventory');
            $table->string('image');
            $table->float('rating')->default(0);
            $table->integer('bestseller')->default(0);
            $table->integer('new')->default(1);
            $table->integer('number_of_sale')->default(0);
            $table->string('size')->nullable();
            $table->text('gallery')->nullable();
            $table->enum('pet', ['Chó', 'Mèo']);
            $table->longtext('description');
            // $table->integer('id_user_created')->references('id')->on('users')->onDelete('set null');
            // $table->integer('id_user_updated')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
