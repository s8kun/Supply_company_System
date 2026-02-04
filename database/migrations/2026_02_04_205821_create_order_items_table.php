<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('orderItemID');
            $table->unsignedBigInteger('orderID');
            $table->foreign('orderID')->references('orderID')->on('orders');
            $table->unsignedBigInteger('productID');
            $table->foreign('productID')->references('productID')->on('products');
            $table->integer('quantity');
            $table->decimal('itemTotalPrice', 15, 2);
            $table->string('deliveryStatus')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
