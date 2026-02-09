<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Create reorder notices table.
     */
    public function up(): void
    {
        Schema::create('reorder_notices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('product_name');
            $table->integer('reorder_quantity');
            $table->integer('current_quantity');
            $table->boolean('is_resolved')->default(false);
            $table->timestamps();

            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }

    /**
     * Drop reorder notices table.
     */
    public function down(): void
    {
        Schema::dropIfExists('reorder_notices');
    }
};
