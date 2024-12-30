<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ChartHarian;
use App\Filament\Widgets\ChartBulanan;
use App\Filament\Widgets\StatsOverview;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $navigationIcon = 'bi-columns-gap';
    protected static ?int $navigationSort = 0;

    public function getColumns(): int | string | array
    {
        return 12;
    }
    // Menambahkan widget ke dashboard
    public function getWidgets(): array
    {
        return [
            StatsOverview::class,   // Menambahkan widget StatsOverview
            ChartHarian::class,     // Menambahkan widget ChartHarian
            ChartBulanan::class,    // Menambahkan widget ChartBulanan
        ];
    }
}
