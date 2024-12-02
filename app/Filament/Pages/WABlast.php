<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class WABlast extends Page
{
    protected static ?string $navigationIcon = 'bi-envelope-arrow-up-fill';
    protected static ?int $navigationSort = 3;
    protected static ?string $slug = 'wablast';
    protected static ?string $title = 'WA Blast';
    protected static string $view = 'filament.pages.wablast';
}
