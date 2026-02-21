<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\BusinessPartner;
use App\Models\ItemSupplier;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ItemSupplierSeeder extends Seeder
{
    public function run(): void
    {
        ItemSupplier::truncate();

        $faker = Faker::create('id_ID');

        $items = Item::pluck('id');
        $vendors = BusinessPartner::where('bptype', 'VEND')->pluck('id');

        if ($items->isEmpty() || $vendors->isEmpty()) {
            $this->command->warn('No items or vendor business partners found. Run ItemSeeder and BusinessPartnerSeeder first.');
            return;
        }

        foreach ($items as $itemId) {
            // Each item gets 1–2 random vendors
            $selectedVendors = $vendors->shuffle()->take(rand(1, 2));
            $isFirst = true;

            foreach ($selectedVendors as $bpId) {
                // Skip if this combination already exists (composite PK)
                if (ItemSupplier::where('item_id', $itemId)->where('bp_id', $bpId)->exists()) {
                    continue;
                }

                ItemSupplier::create([
                    'item_id'   => $itemId,
                    'bp_id'     => $bpId,
                    'vitemcode' => $faker->optional(0.6)->bothify('VEND-###??'),
                    'leadtime'  => $faker->optional()->numberBetween(1, 30),
                    'delivetime'=> $faker->optional()->numberBetween(1, 14),
                    'esttime'   => $faker->optional()->numberBetween(1, 60),
                    'isdefault' => $isFirst,
                ]);

                $isFirst = false;
            }
        }
    }
}
