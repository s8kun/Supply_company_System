<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Create redeem codes table.
     */
    public function up(): void
    {
        Schema::create('redeem_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('amount', 10, 2);
            $table->boolean('isUsed')->default(false);
            $table->timestamp('usedAt')->nullable();
            $table->unsignedBigInteger('usedByCustomerID')->nullable();
            $table->timestamps();

            $table->foreign('usedByCustomerID')->references('customerID')->on('customers');
        });
    }

    /**
     * Drop redeem codes table.
     */
    public function down(): void
    {
        Schema::dropIfExists('redeem_codes');
    }
};
