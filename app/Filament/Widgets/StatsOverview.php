<?php

namespace App\Filament\Widgets;

use App\Models\BusinessPartner;
use App\Models\OfferRequest;
use App\Models\Order; // Import model Order
use App\Models\OrderItem;
use App\Models\Salesman;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make('Penawaran Bulan Ini', OfferRequest::whereMonth('trxdate', Carbon::now()->month)->count())
                ->description('Jumlah penawaran baru bulan ini')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),
            Stat::make('Total Pesanan', Order::count())
                ->description('Jumlah semua pesanan')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),
            Stat::make('Total Revenue', 'Rp ' . number_format(OrderItem::sum(DB::raw('selling_price * quantity')), 0, ',', '.'))
                ->description('Total pendapatan dari semua pesanan')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),
            Stat::make('Revenue Bulan Ini', 'Rp ' . number_format(
                OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->whereMonth('orders.trxdate', Carbon::now()->month)
                    ->whereYear('orders.trxdate', Carbon::now()->year)
                    ->sum(DB::raw('order_items.selling_price * order_items.quantity')),
                0,
                ',',
                '.'
            ))
                ->description('Pendapatan bulan ini')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('danger'),
        ];
    }
}
