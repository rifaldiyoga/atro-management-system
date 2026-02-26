<?php

namespace Database\Seeders;

use App\Models\Salesman;
use App\Models\SalesmanGroup;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SalesmanSeeder extends Seeder
{
    public function run(): void
    {
        Salesman::truncate();
        SalesmanGroup::truncate();
        $faker = Faker::create('id_ID');
        $grp = SalesmanGroup::create(['name' => 'Default Group']);

        Salesman::create([
            'name' => 'PAK SON',
            'code' => '000003',
            'email' => $faker->unique()->safeEmail,
            'srepgrp_id' => $grp->id,
            'active' => true,
        ]);

        Salesman::create([
            'name' => 'PAK FANY',
            'code' => '000004',
            'email' => $faker->unique()->safeEmail,
            'srepgrp_id' => $grp->id,
            'active' => true,
        ]);

        Salesman::create([
            'name' => 'PAK HENDRI',
            'code' => '000005',
            'email' => $faker->unique()->safeEmail,
            'srepgrp_id' => $grp->id,
            'active' => true,
        ]);

        Salesman::create([
            'name' => 'PAK RONI',
            'code' => '000006',
            'email' => $faker->unique()->safeEmail,
            'srepgrp_id' => $grp->id,
            'active' => true,
        ]);

        Salesman::create([
            'name' => 'PAK WAHYU',
            'code' => '000001',
            'email' => $faker->unique()->safeEmail,
            'srepgrp_id' => $grp->id,
            'active' => true,
        ]);
    }
}
