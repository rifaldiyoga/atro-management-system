<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessPartner;
use Faker\Factory as Faker;

class BusinessPartnerSeeder extends Seeder
{
    public function run(): void
    {
        BusinessPartner::truncate();
        $faker = Faker::create('id_ID');

        BusinessPartner::create([
            'name'        => 'PT GRAND TWINS ENGINEERING',
            'email'       => 'hamdan@aqpa-indonesia.com' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'PT CENTRAL PACKING',
            'email'       => 'irawan@gasketpacking.com' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'TECSON International Co., Ltd',
            'email'       => 'Sales2@tecsonst.com' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'PT SUMBER SUKSES SEALINDO',
            'email'       => 'jginting@sumbersealindo.com' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'CV TIGA PERKASA',
            'email'       => 'Seal.kurniawan@gmail.com' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'PAK SUGENG BUBUT GELURAN',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'TOKO APOLLO',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'SAKURA BEARING',
            'email'       => 'sakurabearing@yahoo.com' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'HENAN LANPHAN INDUSTRY CO., LTD',
            'email'       => 'sheroyang@lanphan.com' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'MASTER BAUT',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'PAK LUKMAN',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'PT. NIFA PERSADA TEKNINDO',
            'email'       => 'maryoto@nifa-persada.com / sales@nifa-persada.com' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'PT. ABADI GEMILANG PERKASA',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'CV. BESI SURYA SENTOSA',
            'email'       => 'besi@besibetonsby.com' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'WIJAYA TEKNIK',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'PT. PUTRA ALAM TEKNOLOGI',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'ANEKA ISOLASI',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'PT JAWA POWER',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'AKAR SELANG',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'PT SUPRANUSA INDOGITA',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'BERKAH JAYA SELANGdd',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'PT CHEIL JEDANG INDONESIA jombang',
            'email'       => '(0321)887711' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'PT CHEIL JEDANG INDONESIA pasuruan',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'PT BHUMI JEPARA SERVICE',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'PT PIM Pharmaceuticals',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'PT PAITON ENERGY',
            'email'       => '021 57974525' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'PT PLN NUSANTARA POWER UMRO',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'PT JEBE KOKO',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'PT BHUMI JATI POWER',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'PT LESAFFRE SARI NUSA',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'PT KALTIM PRIMA COAL',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'PT BHIMASENA POWER INDONESIA',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'PT PLN NUSANTARA POWER PAITON',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'PT PETRO JORDAN ABADI',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'PT ATRO INDONESIA GEMILANG',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'PT MITRA FASTENER SUPPLINDO',
            'email'       => 'marketing@mitrafastener.com' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'PT PLN NUSANTARA POWER PACITAN',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'PT ASIAN BEARINDO JAYA',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'TOKOPEDIA',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'SENTOSO SEAL',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'PT PETROKIMIA GRESIK',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'PT SASA INTI GENDING',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'SENTRAL SEAL',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'PT SANTOSA ABADI PACKING',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'CV ANGGI TEHNIK',
            'email'       => 'tes@a.asd' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'VEND',
        ]);

        BusinessPartner::create([
            'name'        => 'PT CIREBON ENERGI PRASARANAs',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);

        BusinessPartner::create([
            'name'        => 'PT ABADI GEMILANG PERKASAss',
            'email'       => '' ?: $faker->unique()->safeEmail,
            'website'     => $faker->optional()->url,
            'bankname'    => $faker->optional()->company,
            'bankaccno'   => $faker->optional()->bankAccountNumber,
            'bankaccname' => $faker->optional()->name,
            'cmpname'     => $faker->optional()->company,
            'note'        => '' ?: $faker->optional()->sentence,
            'active'      => true,
            'bptype'      => 'CUST',
        ]);
    }
}
