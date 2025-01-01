<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Imports\CustomerImporter;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CustomerResource;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make('import')->label('Import Donatur DB')->importer(CustomerImporter::class),
            CreateAction::make()->label('Tambah Customer'),
        ];
    }
}
