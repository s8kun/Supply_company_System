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
        Schema::create('customers', function (Blueprint $table) : void {
            $table->id('customerID');

            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');

            // تفاصيل العنوان
            $table->string('house_no');
            $table->string('street_name');
            $table->string('city');
            $table->string('zip_code');

            $table->string('phone')->unique();
            $table->decimal('credit_limit', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
