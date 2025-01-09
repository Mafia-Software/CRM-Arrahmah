<?php

namespace App\Filament\Widgets;

use App\Models\PesanKeluar;
use App\Models\PesanMasuk;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ChartHarian extends ChartWidget
{
    protected static ?string $heading = 'Statistik Pesan Harian';
    protected static ?int $sort = 20;
    protected int | string | array $columnSpan = ['sm' => 12, 'xl' => 6];

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $dailyPesanKeluar = [];
        $dailyPesanMasuk = [];
        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth();

        for ($day = 1; $day <= $today->daysInMonth; $day++) {
            $date = $startOfMonth->copy()->addDays($day - 1);
            $count = PesanKeluar::whereDate('created_at', $date)->count();
            $dailyPesanKeluar[] = $count;
        }
        for ($day = 1; $day <= $today->daysInMonth; $day++) {
            $date = $startOfMonth->copy()->addDays($day - 1);
            $count = PesanMasuk::whereDate('created_at', $date)->count();
            $dailyPesanMasuk[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pesan Keluar',
                    'data' => $dailyPesanKeluar,
                    'borderColor' => 'red',
                ],
                [
                    'label' => 'Pesan Masuk',
                    'data' => $dailyPesanMasuk,
                    'borderColor' => 'blue',
                ],
            ],
            'labels' => range(1, $today->daysInMonth),
        ];
    }
}
