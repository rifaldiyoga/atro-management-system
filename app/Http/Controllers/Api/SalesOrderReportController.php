<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesOrderReportController extends Controller
{
  public function getReport(Request $request, $type)
  {
    $startDate = $request->query('start_date');
    $endDate = $request->query('end_date');

    $query = null;

    switch ($type) {
      case 'detail-faktur':
        $query = DB::table('so')
          ->join('sod', 'so.id', '=', 'sod.so_id')
          ->leftJoin('bp', 'so.bp_id', '=', 'bp.id')
          ->select(
            'so.trxno',
            'so.trxdate',
            'bp.name as customer_name',
            'sod.itemname',
            'sod.qty',
            'sod.unit',
            'sod.listprice',
            'sod.subtotal'
          )
          ->where('so.isvoid', false);
        if ($startDate) $query->where('so.trxdate', '>=', $startDate);
        if ($endDate) $query->where('so.trxdate', '<=', $endDate . ' 23:59:59');
        break;

      case 'rekap-faktur':
        $query = DB::table('so')
          ->leftJoin('bp', 'so.bp_id', '=', 'bp.id')
          ->select(
            'so.trxno',
            'so.trxdate',
            'bp.name as customer_name',
            'so.subtotal',
            'so.discamt',
            'so.taxamt',
            'so.total',
            'so.status'
          )
          ->where('so.isvoid', false);
        if ($startDate) $query->where('so.trxdate', '>=', $startDate);
        if ($endDate) $query->where('so.trxdate', '<=', $endDate . ' 23:59:59');
        break;

      case 'rekap-produk':
        $query = DB::table('sod')
          ->join('so', 'so.id', '=', 'sod.so_id')
          ->select(
            'sod.itemname',
            DB::raw('SUM(sod.qty) as total_qty'),
            'sod.unit',
            DB::raw('SUM(sod.subtotal) as total_amount')
          )
          ->where('so.isvoid', false);
        if ($startDate) $query->where('so.trxdate', '>=', $startDate);
        if ($endDate) $query->where('so.trxdate', '<=', $endDate . ' 23:59:59');
        $query->groupBy('sod.itemname', 'sod.unit');
        break;

      case 'rekap-salesman':
        $query = DB::table('so')
          ->leftJoin('srep', 'so.srep_id', '=', 'srep.id')
          ->select(
            'srep.name as salesman_name',
            DB::raw('COUNT(so.id) as total_orders'),
            DB::raw('SUM(so.total) as total_amount')
          )
          ->where('so.isvoid', false);
        if ($startDate) $query->where('so.trxdate', '>=', $startDate);
        if ($endDate) $query->where('so.trxdate', '<=', $endDate . ' 23:59:59');
        $query->groupBy('srep.name');
        break;

      case 'riwayat-produk':
        $query = DB::table('sod')
          ->join('so', 'so.id', '=', 'sod.so_id')
          ->leftJoin('bp', 'so.bp_id', '=', 'bp.id')
          ->select(
            'so.trxdate',
            'so.trxno',
            'bp.name as customer_name',
            'sod.itemname',
            'sod.qty',
            'sod.unit',
            'sod.listprice'
          )
          ->where('so.isvoid', false);
        if ($startDate) $query->where('so.trxdate', '>=', $startDate);
        if ($endDate) $query->where('so.trxdate', '<=', $endDate . ' 23:59:59');
        break;

      default:
        return response()->json(['error' => 'Invalid report type'], 400);
    }

    return response()->json([
      'success' => true,
      'data' => $query->get()
    ]);
  }
}
