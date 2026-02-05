<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add images JSON column and remove legacy image column.
     */
    public function up(): void
    {
        if (Schema::hasTable('product_images')) {
            Schema::dropIfExists('product_images');
        }

        $addImages = !Schema::hasColumn('products', 'images');
        $dropImage = Schema::hasColumn('products', 'image');

        if ($addImages || $dropImage) {
            Schema::table('products', function (Blueprint $table) use ($addImages, $dropImage) {
                if ($addImages) {
                    $table->json('images')->nullable()->after('reorderQuantity');
                }
                if ($dropImage) {
                    $table->dropColumn('image');
                }
            });
        }
    }

    /**
     * Restore legacy image column and remove images JSON.
     */
    public function down(): void
    {
        $addImage = !Schema::hasColumn('products', 'image');
        $dropImages = Schema::hasColumn('products', 'images');

        if ($addImage || $dropImages) {
            Schema::table('products', function (Blueprint $table) use ($addImage, $dropImages) {
                if ($addImage) {
                    $table->string('image')->nullable();
                }
                if ($dropImages) {
                    $table->dropColumn('images');
                }
            });
        }
    }
};
