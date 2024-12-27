<?php

namespace App\Filament\Resources\PesanMasukResource\Pages;

use App\Filament\Resources\PesanMasukResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPesanMasuks extends ListRecords
{
    protected static string $resource = PesanMasukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
