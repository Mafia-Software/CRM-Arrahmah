<?php

namespace App\Filament\Resources\WhatsAppServerResource\Pages;

use App\Filament\Resources\WhatsAppServerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWhatsAppServer extends EditRecord
{
    protected static string $resource = WhatsAppServerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
