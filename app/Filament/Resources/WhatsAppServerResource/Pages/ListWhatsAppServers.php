<?php

namespace App\Filament\Resources\WhatsAppServerResource\Pages;

use App\Filament\Resources\WhatsAppServerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWhatsAppServers extends ListRecords
{
    protected static string $resource = WhatsAppServerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah WhatsApp Server'),
        ];
    }
}
