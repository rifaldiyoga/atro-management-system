<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryReportController extends Controller
{
  public function getReport(Request $request, $type)
  {
    $startDate = $request->query('start_date');
    $endDate   = $request->query('end_date');

    $query = null;

    switch ($type) {
      case 'detail-pengiriman':
        $query = DB::table('deli')
          ->join('delid', 'deli.id', '=', 'delid.deli_id')
          ->leftJoin('bp', 'deli.bp_id', '=', 'bp.id')
          ->select(
            'deli.trxno',
            'deli.trxdate',
            'deli.reqdtime',
            'deli.shiptime',
            'bp.name as customer_name',
            'delid.itemname',
            'delid.qty',
            'delid.unit'
          )
          ->where('deli.isvoid', false);
        if ($startDate) $query->where('deli.trxdate', '>=', $startDate);
        if ($endDate) $query->where('deli.trxdate', '<=', $endDate . ' 23:59:59');
        break;

      case 'rekap-pengiriman':
        $query = DB::table('deli')
          ->leftJoin('bp', 'deli.bp_id', '=', 'bp.id')
          ->select(
            'deli.trxno',
            'deli.trxdate',
            'deli.reqdtime',
            'deli.shiptime',
            'bp.name as customer_name',
            'deli.status'
          )
          ->where('deli.isvoid', false);
        if ($startDate) $query->where('deli.trxdate', '>=', $startDate);
        if ($endDate) $query->where('deli.trxdate', '<=', $endDate . ' 23:59:59');
        break;

      case 'rekap-produk':
        $query = DB::table('delid')
          ->join('deli', 'deli.id', '=', 'delid.deli_id')
          ->select(
            'delid.itemname',
            DB::raw('SUM(delid.qty) as total_qty'),
            'delid.unit'
          )
          ->where('deli.isvoid', false);
        if ($startDate) $query->where('deli.trxdate', '>=', $startDate);
        if ($endDate) $query->where('deli.trxdate', '<=', $endDate . ' 23:59:59');
        $query->groupBy('delid.itemname', 'delid.unit');
        break;

      case 'rekap-customer':
        $query = DB::table('deli')
          ->leftJoin('bp', 'deli.bp_id', '=', 'bp.id')
          ->select(
            'bp.name as customer_name',
            DB::raw('COUNT(deli.id) as total_pengiriman'),
            DB::raw('SUM(delid_agg.total_qty) as total_qty')
          )
          ->leftJoinSub(
            DB::table('delid')->select('deli_id', DB::raw('SUM(qty) as total_qty'))->groupBy('deli_id'),
            'delid_agg',
            'deli.id',
            '=',
            'delid_agg.deli_id'
          )
          ->where('deli.isvoid', false);
        if ($startDate) $query->where('deli.trxdate', '>=', $startDate);
        if ($endDate) $query->where('deli.trxdate', '<=', $endDate . ' 23:59:59');
        $query->groupBy('bp.name');
        break;

      case 'rekap-salesman':
        $query = DB::table('deli')
          ->leftJoin('srep', 'deli.srep_id', '=', 'srep.id')
          ->select(
            'srep.name as salesman_name',
            DB::raw('COUNT(deli.id) as total_pengiriman')
          )
          ->where('deli.isvoid', false);
        if ($startDate) $query->where('deli.trxdate', '>=', $startDate);
        if ($endDate) $query->where('deli.trxdate', '<=', $endDate . ' 23:59:59');
        $query->groupBy('srep.name');
        break;

      default:
        return response()->json(['error' => 'Invalid report type'], 400);
    }

    return response()->json([
      'success' => true,
      'data'    => $query->get()
    ]);
  }
}
