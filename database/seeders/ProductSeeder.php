<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Seed products with prices, stock, and placeholder images.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $placeholders = [
            'placeholders/product-1.png',
            'placeholders/product-2.png',
            'placeholders/product-3.png',
            'placeholders/product-4.png',
        ];

        for ($i = 0; $i < 12; $i++) {
            $costPrice = $faker->randomFloat(2, 5, 50);
            $sellPrice = $faker->randomFloat(2, $costPrice + 1, $costPrice + 40);
            $reorderLevel = $faker->numberBetween(5, 20);
            $reorderQuantity = $faker->numberBetween($reorderLevel, $reorderLevel + 40);
            $images = $placeholders;
            shuffle($images);
            $images = array_slice($images, 0, $faker->numberBetween(3, 4));

            Product::query()->create([
                'name' => $faker->unique()->words(2, true),
                'description' => $faker->sentence(8),
                'costPrice' => $costPrice,
                'sellPrice' => $sellPrice,
                'currentQuantity' => $faker->numberBetween(0, 120),
                'reorderLevel' => $reorderLevel,
                'reorderQuantity' => $reorderQuantity,
                'images' => $images,
            ]);
        }
    }
}
