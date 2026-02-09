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
            $table->boolean('is_used')->default(false);
            $table->timestamp('used_at')->nullable();
            $table->unsignedBigInteger('used_by_customer_id')->nullable();
            $table->timestamps();

            $table->foreign('used_by_customer_id')->references('customer_id')->on('customers');
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
