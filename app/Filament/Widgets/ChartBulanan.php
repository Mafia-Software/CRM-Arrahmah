<?php
namespace App\Filament\Widgets;

use App\Models\PesanKeluar;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ChartBulanan extends ChartWidget
{
    protected static ?string $heading = 'Statistik Pesan Keluar Bulanan';
    protected static ?int $sort = 20;
    protected int | string | array $columnSpan = 'full';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $monthlyData = [];


        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create(date('Y'), $month, 1);
            $endDate = $startDate->copy()->endOfMonth();

            $count = PesanKeluar::whereBetween('created_at', [$startDate, $endDate])->count();
            $monthlyData[] = $count;
        }

        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // Label untuk bulan
            'datasets' => [
                [
                    'label' => 'Statistik Bulanan',
                    'data' => $monthlyData,
                    'borderColor' => 'red',
                ],
            ],
        ];
    }
}
