<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        Item::truncate();

        $faker = Faker::create('id_ID');

        foreach (range(1, 50) as $index) {
            Item::create([
                'name'          => $faker->unique()->word . ' ' . $faker->word,
                'unit'          => $faker->randomElement(['EA', 'SHEET']),
                'price'         => $faker->numberBetween(10000, 1000000),
                'lastpurcprice' => $faker->numberBetween(8000, 900000),
                'description'   => $faker->sentence(10),
                'active'        => $faker->boolean(95),
                'photo_url'     => null,
            ]);
        }
    }
}
