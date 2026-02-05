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
        Schema::create('reorder_notices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('productID');
            $table->string('productName');
            $table->integer('reorderQuantity');
            $table->integer('currentQuantity');
            $table->boolean('isResolved')->default(false);
            $table->timestamps();

            $table->foreign('productID')->references('productID')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reorder_notices');
    }
};
