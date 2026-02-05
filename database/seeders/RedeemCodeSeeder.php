<?php

namespace Database\Seeders;

use App\Models\RedeemCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class RedeemCodeSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 8; $i++) {
            RedeemCode::query()->create([
                'code' => Str::upper(Str::random(12)),
                'amount' => $faker->randomFloat(2, 50, 500),
                'isUsed' => false,
            ]);
        }
    }
}
