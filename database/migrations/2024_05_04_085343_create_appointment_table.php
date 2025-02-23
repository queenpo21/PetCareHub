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
        Schema::create('appointment', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->string('code');
            $table->integer('staff_id')->references('id')->on('users')->onDelete('set null');
            $table->integer('cus_id')->references('id')->on('users')->onDelete('set null');
            $table->integer('pet_id')->references('id')->on('pet')->onDelete('set null');
            $table->integer('number_service');
            $table->integer('number_days_send');
            $table->date('appointment_date');
            $table->enum('timeslot',['8:00-9:30','9:30-11:00','13:30-14:00','14:00-15:30','15:30-17:00']);
            $table->double('discount');
            $table->enum('discount_type',['tiền mặt','phần trăm']);
            $table->double('total');
            $table->enum('method_payment',['Tiền mặt','Chuyển khoản']);
            $table->enum('status_payment',['Chưa thanh toán','Đã thanh toán']);
            $table->enum('appointment_status',['Cuộc hẹn đã được đặt','Sắp tới ngày hẹn','Tới ngày hẹn', 'Đã diễn ra', 'Hủy']);
            $table->text('cancellaton_reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment');
    }
};
