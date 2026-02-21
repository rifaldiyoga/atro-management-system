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

        $groupA = SalesmanGroup::create(['name' => 'Group A']);
        $groupB = SalesmanGroup::create(['name' => 'Group B']);

        $salesmen = [
            ['name' => 'WAHYU',  'code' => '000001', 'email' => 'wahyu@example.com',  'srepgrp_id' => $groupA->id],
            ['name' => 'SONI',   'code' => '000002', 'email' => 'soni@example.com',   'srepgrp_id' => $groupA->id],
            ['name' => 'FANY',   'code' => '000003', 'email' => 'fany@example.com',   'srepgrp_id' => $groupB->id],
            ['name' => 'HENDRI', 'code' => '000004', 'email' => 'hendri@example.com', 'srepgrp_id' => $groupB->id],
            ['name' => 'RONI',   'code' => '000005', 'email' => 'roni@example.com',   'srepgrp_id' => $groupB->id],
        ];

        foreach ($salesmen as $data) {
            Salesman::create(array_merge($data, ['active' => true]));
        }
    }
}
