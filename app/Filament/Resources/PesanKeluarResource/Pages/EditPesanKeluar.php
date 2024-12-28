<?php

namespace App\Filament\Resources\PesanKeluarResource\Pages;

use App\Filament\Resources\PesanKeluarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPesanKeluar extends EditRecord
{
    protected static string $resource = PesanKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
