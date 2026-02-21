<?php

namespace Database\Seeders;

use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use App\Models\BusinessPartner;
use App\Models\Item;
use App\Models\Tax;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SalesOrderSeeder extends Seeder
{
    public function run(): void
    {
        SalesOrderDetail::truncate();
        SalesOrder::truncate();

        $faker = Faker::create('id_ID');

        $customers = BusinessPartner::where('bptype', 'CUST')->pluck('id');
        $items = Item::all();
        $taxCodes = Tax::pluck('code')->toArray();

        if ($customers->isEmpty() || $items->isEmpty()) {
            $this->command->warn('Missing dependencies. Run BusinessPartnerSeeder and ItemSeeder first.');
            return;
        }

        foreach (range(1, 10) as $i) {
            $so = SalesOrder::create([
                'trxno'     => 'SO-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'trxdate'   => $faker->dateTimeBetween('-3 months', 'now'),
                'bp_id'     => $customers->random(),
                'version'   => 1,
                'isdraft'   => false,
                'isvoid'    => false,
                'status'    => $faker->randomElement(['OPEN', 'PROCESSING', 'CLOSED']),
                'active'    => true,
                'taxed'     => true,
                'taxinc'    => false,
                'billaddr'  => $faker->address,
                'shipaddr'  => $faker->address,
                'dpamt'     => 0,
                'isautogen' => false,
                'subtotal'  => 0,
                'basesubtotal' => 0,
                'discamt'   => 0,
                'basediscamt' => 0,
                'taxamt'    => 0,
                'basetaxamt'=> 0,
                'basefistaxamt' => 0,
                'total'     => 0,
                'basetotal' => 0,
                'note'      => $faker->optional()->sentence,
                'created_by'=> 1,
                'updated_by'=> 1,
            ]);

            $lineItems = $items->random(rand(1, 5));
            $subtotal = 0;

            foreach ($lineItems as $item) {
                $qty  = $faker->numberBetween(1, 20);
                $cost = $item->price;
                $line = $qty * $cost;
                $subtotal += $line;

                SalesOrderDetail::create([
                    'so_id'             => $so->id,
                    'dno'               => $lineItems->search($item) + 1,
                    'item_id'           => $item->id,
                    'itemname'          => $item->name,
                    'qty'               => $qty,
                    'unit'              => $item->unit,
                    'conv'              => 1,
                    'qtyx'              => $qty,
                    'cost'              => $cost,
                    'baseprice'         => $cost,
                    'listprice'         => $cost,
                    'discamt'           => 0,
                    'totaldiscamt'      => 0,
                    'disc2amt'          => 0,
                    'totaldisc2amt'     => 0,
                    'subtotal'          => $line,
                    'basesubtotal'      => $line,
                    'tax_code'          => !empty($taxCodes) ? $taxCodes[0] : null,
                    'taxableamt'        => $line,
                    'taxamt'            => round($line * 0.11, 4),
                    'totaltaxamt'       => round($line * 0.11, 4),
                    'basetotaltaxamt'   => round($line * 0.11, 4),
                    'basefistotaltaxamt'=> round($line * 0.11, 4),
                    'basetotaltaxamt4'  => round($line * 0.11, 4),
                    'basefistotaltaxamt4' => round($line * 0.11, 4),
                ]);
            }

            $taxamt = round($subtotal * 0.11, 4);
            $so->update([
                'subtotal'  => $subtotal,
                'basesubtotal' => $subtotal,
                'taxamt'    => $taxamt,
                'basetaxamt'=> $taxamt,
                'basefistaxamt' => $taxamt,
                'total'     => $subtotal + $taxamt,
                'basetotal' => $subtotal + $taxamt,
            ]);
        }
    }
}
