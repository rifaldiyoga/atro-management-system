<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleReportController extends Controller
{
  public function getReport(Request $request, $type)
  {
    $startDate = $request->query('start_date');
    $endDate   = $request->query('end_date');

    $query = null;

    switch ($type) {
      case 'detail-faktur':
        $query = DB::table('sale')
          ->join('saled', 'sale.id', '=', 'saled.sale_id')
          ->leftJoin('bp', 'sale.bp_id', '=', 'bp.id')
          ->select(
            'sale.trxno',
            'sale.trxdate',
            'sale.due_date',
            'bp.name as customer_name',
            'saled.itemname',
            'saled.qty',
            'saled.unit',
            'saled.listprice',
            'saled.subtotal'
          )
          ->where('sale.isvoid', false);
        if ($startDate) $query->where('sale.trxdate', '>=', $startDate);
        if ($endDate) $query->where('sale.trxdate', '<=', $endDate . ' 23:59:59');
        break;

      case 'rekap-faktur':
        $query = DB::table('sale')
          ->leftJoin('bp', 'sale.bp_id', '=', 'bp.id')
          ->select(
            'sale.trxno',
            'sale.trxdate',
            'sale.due_date',
            'bp.name as customer_name',
            'sale.subtotal',
            'sale.discamt',
            'sale.taxamt',
            'sale.total',
            'sale.status'
          )
          ->where('sale.isvoid', false);
        if ($startDate) $query->where('sale.trxdate', '>=', $startDate);
        if ($endDate) $query->where('sale.trxdate', '<=', $endDate . ' 23:59:59');
        break;

      case 'rekap-produk':
        $query = DB::table('saled')
          ->join('sale', 'sale.id', '=', 'saled.sale_id')
          ->select(
            'saled.itemname',
            DB::raw('SUM(saled.qty) as total_qty'),
            'saled.unit',
            DB::raw('SUM(saled.subtotal) as total_amount')
          )
          ->where('sale.isvoid', false);
        if ($startDate) $query->where('sale.trxdate', '>=', $startDate);
        if ($endDate) $query->where('sale.trxdate', '<=', $endDate . ' 23:59:59');
        $query->groupBy('saled.itemname', 'saled.unit');
        break;

      case 'rekap-salesman':
        $query = DB::table('sale')
          ->leftJoin('srep', 'sale.srep_id', '=', 'srep.id')
          ->select(
            'srep.name as salesman_name',
            DB::raw('COUNT(sale.id) as total_invoices'),
            DB::raw('SUM(sale.total) as total_amount')
          )
          ->where('sale.isvoid', false);
        if ($startDate) $query->where('sale.trxdate', '>=', $startDate);
        if ($endDate) $query->where('sale.trxdate', '<=', $endDate . ' 23:59:59');
        $query->groupBy('srep.name');
        break;

      case 'rekap-customer':
        $query = DB::table('sale')
          ->leftJoin('bp', 'sale.bp_id', '=', 'bp.id')
          ->select(
            'bp.name as customer_name',
            DB::raw('COUNT(sale.id) as total_invoices'),
            DB::raw('SUM(sale.total) as total_amount')
          )
          ->where('sale.isvoid', false);
        if ($startDate) $query->where('sale.trxdate', '>=', $startDate);
        if ($endDate) $query->where('sale.trxdate', '<=', $endDate . ' 23:59:59');
        $query->groupBy('bp.name');
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
