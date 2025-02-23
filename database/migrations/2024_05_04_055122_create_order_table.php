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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->string('code');
            $table->string('user_id')->references('id')->on('users')->onDelete('cascade')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address')->default('Pet Care Hub');
            $table->text('note')->nullable();
            $table->double('shipcost')->default('30000');
            $table->integer('discount')->default('0');
            $table->double('total');
            $table->enum('method_payment', ['Tiền mặt', 'Thanh toán online']);
            $table->enum('status', ['Chờ xác nhận', 'Đang giao', 'Đã giao', 'Đã hủy'])->default('Chờ xác nhận');
            $table->integer('status_payment')->default('0');
            $table->text('cancelllation_reason')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
