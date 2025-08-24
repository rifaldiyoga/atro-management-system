<?php

namespace Database\Seeders;

use App\Models\Salesman;
use App\Models\SalesmanGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesmanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel untuk menghindari duplikasi data
        Salesman::truncate();
        SalesmanGroup::truncate();

        // Buat grup salesman terlebih dahulu
        $timA = SalesmanGroup::create(['name' => 'Tim A']);
        $timB = SalesmanGroup::create(['name' => 'TIM B']);

        // Buat data salesman dan kaitkan dengan grup yang sesuai
        Salesman::create([
            'name' => 'WAHYU',
            'code' => '000001',
            'phone' => '123',
            'salesman_group_id' => $timA->id,
        ]);

        Salesman::create([
            'name' => 'SONI',
            'code' => '000003',
            'phone' => '789',
            'salesman_group_id' => $timA->id,
        ]);

        Salesman::create([
            'name' => 'FANY',
            'code' => '000004',
            'phone' => '456',
            'salesman_group_id' => $timB->id,
        ]);

        Salesman::create([
            'name' => 'HENDRI',
            'code' => '000005',
            'phone' => '321',
            'salesman_group_id' => $timB->id,
        ]);

        Salesman::create([
            'name' => 'RONI',
            'code' => '000006',
            'phone' => '654',
            'salesman_group_id' => $timB->id,
        ]);
    }
}
