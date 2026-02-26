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

        Item::create([
            'name'          => 'MEMBRANE KANVAS SIZE W: 1 M X THK: 1MM',
            'unit'          => 'METER',
            'price'         => 180000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (180000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'VACUM RUBBER SUCTION CUP, PRODEC',
            'unit'          => 'EA',
            'price'         => 215000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (215000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'GLAND PACKING SIZE 25 MM SQUARE, MATR : FIBBER GLASS',
            'unit'          => 'BOX',
            'price'         => 750000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (750000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '1.450.000 (HAMDAN)
750.000 (ALIONG) 

' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'NOC SEAL TC 30-45 10-2',
            'unit'          => 'EA',
            'price'         => null ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (false ? (null * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'NOC SEAL 75 X 55 X 12 MM',
            'unit'          => 'EA',
            'price'         => null ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (false ? (null * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'SET SCREW, SIZE: M 16 X 25, MATR: A193 GR.B7 / SCM435',
            'unit'          => 'SET',
            'price'         => 135000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (135000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'SWG 304 - 304 - PTFE - 304 3" X JIS 10K ',
            'unit'          => 'EA',
            'price'         => 55000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (55000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'BLIND FERRULE 2 INCH MATR: SS316',
            'unit'          => 'EA',
            'price'         => 123123123.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (123123123.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'SWG 304 - 304 - PTFE 12" X 10K',
            'unit'          => 'EA',
            'price'         => 100000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (100000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'SONSEAL 9000 2 MM X 1500 X 1500 MM',
            'unit'          => 'SHEET',
            'price'         => 260000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (260000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'OIL SEAL 50,8 X 76,2 X 7,92 MM',
            'unit'          => 'EA',
            'price'         => 350000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (350000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'PACKING ORING P/N: P-5125, SIZE 114,34 MM ID X 125,06 MM OD X 5,36 MM THK MAT: EPDM TEMP: 100\'C',
            'unit'          => 'EA',
            'price'         => 857500.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (857500.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'Flexible (Expansion) Joint for Air Flushing Fan Size: D1 : 166,87 mm D2 : 170,38 mm Length : 330 mm',
            'unit'          => 'EA',
            'price'         => 2000000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (2000000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => ' Type: Fabric cloth (Black PTFE) with Wire Reinforce Clamp Wire Material: SS 316  Clamp Material: SS 304' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'SONSEAL 9000 1 MM X 1500 X 1500 MM',
            'unit'          => 'SHEET',
            'price'         => 328000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (328000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'ORING SIZE: 179.2 MM X 5.7MM, MATERIAL: VITON 75 SHORE',
            'unit'          => 'EA',
            'price'         => 450000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (450000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => 'TEGUH : 450.000
TOKPED : 180.000 

' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'ORING, SIZE: 360 MM X 4 MM, MATERIAL: VITON',
            'unit'          => 'EA',
            'price'         => 385000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (385000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => 'TEGUH : 385.000
TOKPED : 270.000 

' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'ORING, SIZE: 209.2 MM X 5.7 MM, MATERIAL: VITON',
            'unit'          => 'EA',
            'price'         => 435000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (435000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => 'TEGUH : 435.000
TOKPED : 210.000 

' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'GASKET RUBBER EPDM 5T X 1200 MM',
            'unit'          => 'METER',
            'price'         => 123000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (123000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'OIL SEAL TC 80 X 115 X 13MM, MATERIAL VITON',
            'unit'          => 'EA',
            'price'         => 240000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (240000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'OIL SEAL TC 90 X 115 X 13MM, MATERIAL VITON',
            'unit'          => 'EA',
            'price'         => 240000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (240000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'EXPANTION JOINT METAL SS304 Size : DN 300 x OAL 295, ANSI 150',
            'unit'          => 'EA',
            'price'         => 36500000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (36500000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'KARET PENYEDOT DOS / VACUM TAPE, UK. 6 X 26 X 15 MM ',
            'unit'          => 'EA',
            'price'         => 65000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (65000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'STEEL MESH, 1800*1000, OPENING 75*100 15MM WIRE',
            'unit'          => 'EA',
            'price'         => 3780000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (3780000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => 'FOR VIBRATING SCREEN FOR VIBRATING SCREEN 00EBC
Material : ASTM 128 GR B2' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'PTFE LINING PTFE LINED TANK  SIZE : DIA 712MM X 511MM',
            'unit'          => 'EA',
            'price'         => 49111000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (49111000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'OIL SEAL TYPE: TC, SIZE: 50MM ID X 90MM OD X 8MM THICK, MATERIAL: NBR',
            'unit'          => 'EA',
            'price'         => 30000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (30000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => 'BRAND: NAK. SIZE ( 50 X 90 X 8 AS )' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'V BELT 17MM; 10MM; 1270MM MITSUBOSHI B50',
            'unit'          => 'EA',
            'price'         => 36000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (36000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'V BELT 17MM; 10MM; 1219 MECHANICAL PARTS MITSUBOSHI B48',
            'unit'          => 'EA',
            'price'         => 34600.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (34600.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'BLIND FERRULE 3 INCH MATR: SS316',
            'unit'          => 'EA',
            'price'         => 115000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (115000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'Spring for Hot/Cold Air Gate Limit SwitcSpring Material CS Normal length 100 mm  Strain length 160 mm  Spring material diameter 2.7 mm ',
            'unit'          => 'EA',
            'price'         => 75000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (75000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'V BELT 17MM; 10MM; 1778MM MITSUBOSHI B70',
            'unit'          => 'EA',
            'price'         => 50400.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (50400.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'V BELT 12.7MM; 7.9MM; 2159MM MITSUBOSHI A83',
            'unit'          => 'EA',
            'price'         => 39900.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (39900.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'ELECTRODE; FOR PLASMA CUTTING MACHINE P82; TYPE: TET02033- EC',
            'unit'          => 'EA',
            'price'         => 50000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (50000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'NOZZLE; 1.3 MM; FOR PLASMA CUTTING MACHINE P81; TYPE: TET01305',
            'unit'          => 'EA',
            'price'         => 50000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (50000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'NOZZLE; 1.5 MM; FOR PLASMA CUTTING MACHINE P80; TYPE: TET01507-EC',
            'unit'          => 'EA',
            'price'         => 50000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (50000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'CUP, SHIED; FOR PLASMA CUTTING MACHINE P80; TYPE: THN02004',
            'unit'          => 'EA',
            'price'         => 50000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (50000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'MECHANICAL SEAL TYPE : MG1, DIA : 35MM, SIC/SIC/VITON',
            'unit'          => 'EA',
            'price'         => 3700000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (3700000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'PACKING, GRAPHITE, MOLDED, 28 X 46 X 7 MM, FOR MOV SUPPLY SOOTBLOWER',
            'unit'          => 'EA',
            'price'         => null ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (false ? (null * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'PACKING, GRAPHITE, MOLDED, 28 X 42 X 7 MM',
            'unit'          => 'EA',
            'price'         => null ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (false ? (null * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => 'FOR MOV SUPPLY SOOTBLOWER


BUAT SENDIRI' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'METALIC FLEXIBLE JOINT SS316 TOTAL LENGT TOTAL LENGT 425 MM SISI RAJUT 315 MM EXTENSION PIPA STAINLESS 316 PRESSURE 8MPa FLUIDA OIL CONNECTION FITTING END',
            'unit'          => 'EA',
            'price'         => 3000000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (3000000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'METALIC FLEXIBLE JOINT SS316 TOTAL LENGT TOTAL LENGT 425 MM SISI RAJUT 275 MM  EXTENSION PIPA STAINLESS 316 PRESSURE 15MPa FLUIDA OIL WELDED END',
            'unit'          => 'EA',
            'price'         => 2500000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (2500000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'EXPANSION JOINT OUT STAGE 1 TO AFTERCOOL LENGTH BETWEEN OAL 173 M FLANGE TO FLANGE 217 MM HOSE DIAMETER 190 MM PCD 230 MM TOTAL BOLT 8  WORKING PRESSURE 10 BAR WORKING TEMPERATURE 270 C MAT : SUS',
            'unit'          => 'EA',
            'price'         => 7500000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (7500000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'RUBBER TENSION SIFTER SCREEN. MATR: SILICONE FOOD GRADE',
            'unit'          => 'ROLL',
            'price'         => 9000000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (9000000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => 'TANPA SERTIFIKAT FOOD GRADE
300.000/M 1ROLL=30M' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'ORING, SIZE : D 520 X CS 5.7 MATR: NBR',
            'unit'          => 'EA',
            'price'         => 1000000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (1000000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'GLAND PACKING SQUARE, SIZE : 15MM, MATR: BRAIDED ASBESTOS GRAPHITE WITH WIRE',
            'unit'          => 'ROLL',
            'price'         => 11500000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (11500000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => 'MFG, FOR RAPH' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'NOC SEAL TC 30 X 47 X 6 MM',
            'unit'          => 'EA',
            'price'         => null ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (false ? (null * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'OIL SEAL 32 X 40 X 4 MM, MATR: VITON',
            'unit'          => 'EA',
            'price'         => 10000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (10000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'COPPER PACKING, MATR: C2801-1/4H, SIZE : DIA 116 MM, THK: 0.5 MM, DRILL THRU: 2 EA-10MM, PCD: 90 EQUAL PITCH',
            'unit'          => 'EA',
            'price'         => 760000.00 ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (true ? (760000.00 * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => '' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);

        Item::create([
            'name'          => 'GASKET, SIZE: 397 MM X 242 MM X 4 MM, MATR: SONSEAL 9200 NON ASBESTOS',
            'unit'          => 'EA',
            'price'         => null ?? $faker->numberBetween(10000, 1000000),
            'lastpurcprice' => (false ? (null * 0.8) : $faker->numberBetween(8000, 900000)),
            'description'   => 'MFG BY PT ATRO INDONESIA GEMILANG' ?: $faker->sentence(10),
            'active'        => true,
            'photo_url'     => '' ?: null,
        ]);
    }
}
