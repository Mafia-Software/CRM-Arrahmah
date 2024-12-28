<?php

namespace App\Filament\Resources\PesanKeluarResource\Pages;

use App\Filament\Resources\PesanKeluarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPesanKeluars extends ListRecords
{
    protected static string $resource = PesanKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
