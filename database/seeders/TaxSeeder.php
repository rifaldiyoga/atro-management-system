<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    public function run(): void
    {
        Tax::truncate();

        $taxes = [
            [
                'code'      => 'PPN',
                'name'      => 'PPN 11%',
                'expr'      => '11%',
                'active'    => true,
                'isdefault' => true,
                'calcdpp'   => '1',
            ],
            [
                'code'      => 'PPN0',
                'name'      => 'PPN 0%',
                'expr'      => '0%',
                'active'    => true,
                'isdefault' => false,
                'calcdpp'   => '1',
            ],
            [
                'code'      => 'EXEMPT',
                'name'      => 'Tax Exempt',
                'expr'      => '0%',
                'active'    => true,
                'isdefault' => false,
                'calcdpp'   => '1',
            ],
        ];

        foreach ($taxes as $tax) {
            Tax::create($tax);
        }
    }
}
