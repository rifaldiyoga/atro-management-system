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
        'code' => 'VENDOR_DEFAULT',
        'name' => 'Supplier Utama',
        'value' => '1',
        'isvisible' => true,
        'modul_code' => 'SYS',
        'valeditor' => 'PikVendor',
        'type' => 'General',
        'note' => 'Bawaan/default supplier ketika membuat transaksi pembelian baru',
        'index' => 3,
      ],
      [
        'code' => 'CUST_DEFAULT',
        'name' => 'Customer Utama',
        'value' => '72',
        'isvisible' => true,
        'modul_code' => 'SYS',
        'valeditor' => 'PikCust',
        'type' => 'General',
        'note' => 'Bawaan/default customer ketika membuat transaksi penjualan baru',
        'index' => 2,
      ],
      [
        'code' => 'ROUND_RPT',
        'name' => 'Pembulatan Nilai Desimal pada Laporan',
        'value' => '4',
        'isvisible' => true,
        'modul_code' => 'SYS',
        'valeditor' => 'cmbRound',
        'type' => 'General',
        'note' => 'Panjang digit pembulatan nilai desimal pada setiap laporan',
        'index' => 19,
      ],
      [
        'code' => 'SRC_PRICE',
        'name' => 'Tipe perhitungan harga jual berdasarkan level harga atau qty',
        'value' => 'QTY',
        'isvisible' => true,
        'modul_code' => 'SYS',
        'valeditor' => 'CmbPrice',
        'type' => 'General',
        'note' => null,
        'index' => null,
      ],
      [
        'code' => 'RPRINT_INPUT',
        'name' => 'Entri Jumlah Baris saat Print',
        'value' => '0',
        'isvisible' => true,
        'modul_code' => 'SYS',
        'valeditor' => 'OnOffButton',
        'type' => 'General',
        'note' => 'Mengisikan jumlah baris setiap akan melakukan print nota transaksi',
        'index' => 22,
      ],
      [
        'code' => 'CASHID_DEFAULT',
        'name' => 'Kas Utama',
        'value' => '1',
        'isvisible' => true,
        'modul_code' => 'SYS',
        'valeditor' => 'CmbCash',
        'type' => 'General',
        'note' => 'Bawaan/default kas/bank ketika membuat transaksi baru',
        'index' => 4,
      ],
      [
        'code' => 'PRCLVL_DEFAULT',
        'name' => 'Level Harga Utama',
        'value' => '1',
        'isvisible' => true,
        'modul_code' => 'SYS',
        'valeditor' => 'cmbPrclvl',
        'type' => 'General',
        'note' => 'Bawaan/default level harga ketika membuat mitra bisnis baru',
        'index' => 5,
      ],
      [
        'code' => 'TAXINC_ENB',
        'name' => 'Gunakan Harga Termasuk Pajak',
        'value' => '1',
        'isvisible' => true,
        'modul_code' => 'SYS',
        'valeditor' => 'OnOffButton',
        'type' => 'General',
        'note' => 'Lebih detail mengenai harga termasuk pajak lihat disini',
        'index' => 10,
      ],
      [
        'code' => 'PRD_TRANS',
        'name' => 'Default Lama Periode Daftar Transaksi',
        'value' => '7',
        'isvisible' => true,
        'modul_code' => 'SYS',
        'valeditor' => 'cmbPrd',
        'type' => 'General',
        'note' => 'Lama waktu bawaan jarak periode, ketika membuka daftar transaksi',
        'index' => 14,
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
