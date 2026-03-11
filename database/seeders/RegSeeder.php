<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reg;

class RegSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $regs = [
      [
        'code' => 'PRC_MARKUP',
        'name' => 'Markup Harga Jual',
        'value' => '70%',
        'isvisible' => true,
        'modul_code' => 'SYS',
        'valeditor' => 'txtNum',
        'type' => 'General',
        'note' => 'Persentase markup harga jual default',
        'index' => 3,
      ],
    ];

    foreach ($regs as $reg) {
      $reg = array_filter($reg, function ($value) {
        return $value !== null;
      });
      Reg::updateOrCreate(['code' => $reg['code']], $reg);
    }
  }
}
