<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class OrderChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pesanan Per Bulan';
    protected static ?int $sort = 3; // Urutan widget di dasbor

    protected function getData(): array
    {
        // Menggunakan fungsi TO_CHAR untuk kompatibilitas dengan PostgreSQL
        $data = Order::select(
            DB::raw("TO_CHAR(trxdate, 'YYYY-MM') as month"),
            DB::raw('COUNT(*) as count')
        )
            ->where('trxdate', '>=', Carbon::now()->subYear())
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Pesanan',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.2)',
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                ],
            ],
            'labels' => $data->pluck('month')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
