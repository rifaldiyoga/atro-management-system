<?php

namespace Database\Seeders;

use App\Models\BpAddr;
use App\Models\BusinessPartner;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BpAddrSeeder extends Seeder
{
    public function run(): void
    {
        BpAddr::truncate();

        $faker = Faker::create('id_ID');

        $bpIds = BusinessPartner::pluck('id');

        if ($bpIds->isEmpty()) {
            $this->command->warn('No business partners found. Run BusinessPartnerSeeder first.');
            return;
        }

        foreach ($bpIds as $bpId) {
            // Billing address
            BpAddr::create([
                'bp_id'      => $bpId,
                'name'       => 'Billing Address',
                'address'    => $faker->address,
                'phone'      => $faker->phoneNumber,
                'zipcode'    => $faker->postcode,
                'email'      => $faker->safeEmail,
                'note'       => null,
                'isbilladdr' => true,
                'isshipaddr' => false,
            ]);

            // Shipping address
            BpAddr::create([
                'bp_id'      => $bpId,
                'name'       => 'Shipping Address',
                'address'    => $faker->address,
                'phone'      => $faker->phoneNumber,
                'zipcode'    => $faker->postcode,
                'email'      => $faker->safeEmail,
                'note'       => null,
                'isbilladdr' => false,
                'isshipaddr' => true,
            ]);
        }
    }
}
