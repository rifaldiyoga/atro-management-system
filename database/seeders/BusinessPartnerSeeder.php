<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BusinessPartner;
use Faker\Factory as Faker;

class BusinessPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BusinessPartner::truncate();

        $faker = Faker::create('id_ID');

        // Create 10 customers
        foreach (range(1, 10) as $index) {
            BusinessPartner::create([
                'name'        => $faker->company,
                'email'       => $faker->unique()->safeEmail,
                'website'     => $faker->optional()->url,
                'bankname'    => $faker->optional()->company,
                'bankaccno'   => $faker->optional()->bankAccountNumber,
                'bankaccname' => $faker->optional()->name,
                'cmpname'     => $faker->optional()->company,
                'note'        => $faker->optional()->sentence,
                'active'      => $faker->boolean(90),
                'bptype'      => 'CUST',
            ]);
        }

        // Create 10 vendors
        foreach (range(1, 10) as $index) {
            BusinessPartner::create([
                'name'        => $faker->company,
                'email'       => $faker->unique()->safeEmail,
                'website'     => $faker->optional()->url,
                'bankname'    => $faker->optional()->company,
                'bankaccno'   => $faker->optional()->bankAccountNumber,
                'bankaccname' => $faker->optional()->name,
                'cmpname'     => $faker->optional()->company,
                'note'        => $faker->optional()->sentence,
                'active'      => $faker->boolean(90),
                'bptype'      => 'VEND',
            ]);
        }
    }
}
