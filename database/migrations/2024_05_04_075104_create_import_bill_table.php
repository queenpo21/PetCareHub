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
        Schema::create('importBill', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->integer('supplier_id')->references('id')->on('supplier')->onDelete('no action');
            $table->string('code');
            $table->datetime('date_import');
            $table->float('total');
            $table->enum('method_payment',['Tiền mặt', 'Chuyển khoản']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('importBill');
    }
};
