<?php

namespace App\Filament\Widgets;

use App\Models\PesanKeluar;
use App\Models\PesanMasuk;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ChartBulanan extends ChartWidget
{
    protected static ?string $heading = 'Statistik Pesan Bulanan';
    protected static ?int $sort = 20;
    protected int | string | array $columnSpan = ['sm' => 12, 'xl' => 6];

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $monthlyPesanKeluar = [];
        $monthlyPesanMasuk = [];
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create(date('Y'), $month, 1);
            $endDate = $startDate->copy()->endOfMonth();
            $count = PesanKeluar::whereBetween('created_at', [$startDate, $endDate])->count();
            $monthlyPesanKeluar[] = $count;
        }
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create(date('Y'), $month, 1);
            $endDate = $startDate->copy()->endOfMonth();
            $countMasuk = PesanMasuk::whereBetween('created_at', [$startDate, $endDate])->count();
            $monthlyPesanMasuk[] = $countMasuk;
        }
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // Label untuk bulan
            'datasets' => [
                [
                    'label' => 'Pesan Keluar',
                    'data' => $monthlyPesanKeluar,
                    'borderColor' => 'red',
                ],
                [
                    'label' => 'Pesan Masuk',
                    'data' => $monthlyPesanMasuk,
                    'borderColor' => 'blue',
                ],
            ],
        ];
    }
}
