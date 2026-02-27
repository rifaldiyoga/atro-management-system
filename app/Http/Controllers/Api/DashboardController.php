<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function summary(Request $request)
  {
    $today        = now()->toDateString();
    $thisMonthStart = now()->startOfMonth()->toDateString();
    $lastMonthStart = now()->subMonth()->startOfMonth()->toDateString();
    $lastMonthEnd   = now()->subMonth()->endOfMonth()->toDateString();

    // ── KPI Cards ──────────────────────────────────────────────────────────────

    // Total revenue this month (sale invoices only, not voided)
    $revenueThisMonth = DB::table('sale')
      ->where('isvoid', false)
      ->whereBetween('trxdate', [$thisMonthStart, $today])
      ->sum('total');

    $revenueLastMonth = DB::table('sale')
      ->where('isvoid', false)
      ->whereBetween('trxdate', [$lastMonthStart, $lastMonthEnd])
      ->sum('total');

    // Total Sales Orders this month
    $soThisMonth = DB::table('so')->where('isvoid', false)
      ->whereBetween('trxdate', [$thisMonthStart, $today])->count();
    $soLastMonth = DB::table('so')->where('isvoid', false)
      ->whereBetween('trxdate', [$lastMonthStart, $lastMonthEnd])->count();

    // Total Deliveries this month
    $deliThisMonth = DB::table('deli')->where('isvoid', false)
      ->whereBetween('trxdate', [$thisMonthStart, $today])->count();
    $deliLastMonth = DB::table('deli')->where('isvoid', false)
      ->whereBetween('trxdate', [$lastMonthStart, $lastMonthEnd])->count();

    // Active Customers (bp with bptype='CUST' and at least one SO)
    $activeCustomers = DB::table('bp')
      ->where('bptype', 'CUST')
      ->whereExists(function ($q) {
        $q->select(DB::raw(1))->from('so')->whereColumn('so.bp_id', 'bp.id')->where('so.isvoid', false);
      })->count();

    // ── Monthly Revenue Chart (last 12 months) ─────────────────────────────────
    $monthlyRevenue = DB::table('sale')
      ->selectRaw("TO_CHAR(trxdate::date, 'Mon') as month, EXTRACT(MONTH FROM trxdate::date) as month_num, EXTRACT(YEAR FROM trxdate::date) as year, SUM(total) as total")
      ->where('isvoid', false)
      ->where('trxdate', '>=', now()->subMonths(11)->startOfMonth()->toDateString())
      ->groupByRaw("TO_CHAR(trxdate::date, 'Mon'), EXTRACT(MONTH FROM trxdate::date), EXTRACT(YEAR FROM trxdate::date)")
      ->orderByRaw("year ASC, month_num ASC")
      ->get();

    // ── Recent Invoices ────────────────────────────────────────────────────────
    $recentSales = DB::table('sale')
      ->leftJoin('bp', 'sale.bp_id', '=', 'bp.id')
      ->select('sale.id', 'sale.trxno', 'sale.trxdate', 'sale.total', 'sale.status', 'bp.name as customer_name')
      ->where('sale.isvoid', false)
      ->orderByDesc('sale.trxdate')
      ->orderByDesc('sale.id')
      ->limit(7)
      ->get();

    // ── Top Customers this month ───────────────────────────────────────────────
    $topCustomers = DB::table('sale')
      ->leftJoin('bp', 'sale.bp_id', '=', 'bp.id')
      ->selectRaw('bp.name as customer_name, COUNT(sale.id) as total_invoices, SUM(sale.total) as total_amount')
      ->where('sale.isvoid', false)
      ->whereBetween('sale.trxdate', [$thisMonthStart, $today])
      ->groupBy('bp.name')
      ->orderByDesc('total_amount')
      ->limit(5)
      ->get();

    // ── SO Pipeline (status counts) ────────────────────────────────────────────
    $soPipeline = DB::table('so')
      ->selectRaw('status, COUNT(*) as count')
      ->where('isvoid', false)
      ->groupBy('status')
      ->get();

    // ── Helper: % change ───────────────────────────────────────────────────────
    $pctChange = function ($current, $previous) {
      if ($previous == 0) return $current > 0 ? 100 : 0;
      return round((($current - $previous) / $previous) * 100, 1);
    };

    return response()->json([
      'success' => true,
      'data' => [
        'kpi' => [
          'revenue_this_month'  => (float) $revenueThisMonth,
          'revenue_last_month'  => (float) $revenueLastMonth,
          'revenue_pct_change'  => $pctChange($revenueThisMonth, $revenueLastMonth),
          'so_this_month'       => (int) $soThisMonth,
          'so_last_month'       => (int) $soLastMonth,
          'so_pct_change'       => $pctChange($soThisMonth, $soLastMonth),
          'deli_this_month'     => (int) $deliThisMonth,
          'deli_last_month'     => (int) $deliLastMonth,
          'deli_pct_change'     => $pctChange($deliThisMonth, $deliLastMonth),
          'active_customers'    => (int) $activeCustomers,
        ],
        'monthly_revenue'  => $monthlyRevenue,
        'recent_sales'     => $recentSales,
        'top_customers'    => $topCustomers,
        'so_pipeline'      => $soPipeline,
      ],
    ]);
  }
}
