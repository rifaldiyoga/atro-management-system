<?php

namespace App\Filament\Widgets;

use App\Models\OfferRequest;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB; // Import DB facade

class OfferRequestChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Permintaan Penawaran';
    protected static ?int $sort = 2; // Urutan widget di dasbor

    protected function getData(): array
    {
        // Menggunakan fungsi TO_CHAR untuk kompatibilitas dengan PostgreSQL
        $data = OfferRequest::select(
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
                    'label' => 'Permintaan Penawaran',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
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
