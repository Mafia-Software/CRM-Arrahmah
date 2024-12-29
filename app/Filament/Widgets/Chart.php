<?php

namespace App\Filament\Widgets;

use App\Models\PesanKeluar;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class Chart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Pesan Keluar';
    protected static ?int $sort = 20;
    protected int | string | array $columnSpan = 'full';
    protected function getData(): array
    {
        $data = [];
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create(date('Y'), $month, 1);
            $endDate = $startDate->copy()->endOfMonth();

            $count = PesanKeluar::whereBetween('created_at', [$startDate, $endDate])->count();
            $data[$month - 1] = $count;
        }
        return [
            'datasets' => [
                [
                    'label' => 'Statistik Pesan Keluar',
                    'data' => $data,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
