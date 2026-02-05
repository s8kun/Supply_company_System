<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Customer::query()->create([
                'first_name' => $faker->firstName,
                'middle_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'house_no' => (string) $faker->numberBetween(1, 250),
                'street_name' => $faker->streetName,
                'city' => $faker->city,
                'zip_code' => $faker->postcode,
                'phone' => $faker->unique()->numerify('05########'),
                'credit_limit' => $faker->randomFloat(2, 300, 5000),
            ]);
        }
    }
}
