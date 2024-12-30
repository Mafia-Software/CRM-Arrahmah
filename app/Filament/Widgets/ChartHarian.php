<?php
namespace App\Filament\Widgets;

use App\Models\PesanKeluar;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ChartHarian extends ChartWidget
{
    protected static ?string $heading = 'Statistik Pesan Keluar Harian';
    protected static ?int $sort = 20;
    protected int | string | array $columnSpan = 'full';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $dailyData = [];


        for ($day = 1; $day <= 31; $day++) {
            $startDate = Carbon::now()->startOfYear()->addDays($day - 1);
            $endDate = $startDate->copy();

            $count = PesanKeluar::whereBetween('created_at', [$startDate, $endDate])->count();
            $dailyData[] = $count;
        }

        return [
            'labels' => range(1, 31),
            'datasets' => [
                [
                    'label' => 'Statistik Harian',
                    'data' => $dailyData,
                    'borderColor' => 'blue',
                ],
            ],
        ];
    }
}
