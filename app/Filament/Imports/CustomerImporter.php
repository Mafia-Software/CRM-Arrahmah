<?php

namespace App\Filament\Imports;

use App\Models\Customer;
use App\Models\UnitKerja;
use Carbon\CarbonInterface;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class CustomerImporter extends Importer
{
    protected static ?string $model = Customer::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->rules(['max:255'])->ignoreBlankState(),
            ImportColumn::make('alamat')
                ->rules(['max:255'])->ignoreBlankState(),
            ImportColumn::make('no_wa')
                ->requiredMapping()
                ->rules(['required', 'max:255'])->castStateUsing(function (string $state): ?string {
                    if (blank($state)) {
                        return null;
                    }
                    if (substr($state, 0, 2) === '62') {
                        return '0' . substr($state, 2);
                    }
                    return $state;
                })->ignoreBlankState(),
            ImportColumn::make('unit_kerja_id')
                ->label('Unit Kerja')
                ->castStateUsing(function (string $state): ?string {
                    $unitKerja = UnitKerja::query()->where('name', $state)->first();
                    if ($unitKerja) {
                        return $unitKerja->id;
                    }
                    return UnitKerja::create(['name' => $state])->id;
                })
                ->ignoreBlankState(),
        ];
    }

    public function resolveRecord(): ?Customer
    {
        return Customer::firstOrNew([
            'no_wa' => $this->data['no_wa'],
        ]);

        //return new Customer();
    }

    public function getJobRetryUntil(): ?CarbonInterface
    {
        return now()->addMinutes(1);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your customer import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
