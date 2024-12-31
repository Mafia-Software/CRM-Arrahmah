<?php

namespace App\Filament\Imports;

use App\Models\Data;
use App\Models\UnitKerja;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;

class DataImporter extends Importer
{
    // protected static ?string $model = Data::class;

    public static function getColumns(): array
    {
        return [
            //
            ImportColumn::make('Nama')
                ->requiredMapping()
                ->label('NAMA')
                ->rules(['required']),
            ImportColumn::make('No Wa')
                ->requiredMapping()
                ->label('No Whatsapp')
                ->rules(['required'])
                ->castStateUsing(function (string $state): ?string {
                    if (blank($state)) {
                        return null;
                    }

                    // Memeriksa apakah nomor diawali dengan '62'
                    if (substr($state, 0, 2) === '62') {
                        // Mengubah awalan '62' menjadi '0'
                        return '0' . substr($state, 2);
                    }

                    // Jika tidak dimulai dengan '62', kembalikan nomor seperti semula
                    return $state;
                }),
            ImportColumn::make('UNIT OWNER')
                ->requiredMapping()
                ->label('Unit Kerja')
                ->rules(['required'])
                ->relationship(
                    resolveUsing: function (string $state) {
                        // Mencari Unit Kerja di database berdasarkan nama unit kerja dari file Excel
                        $unitKerja = UnitKerja::where('name', $state)->first();

                        if ($unitKerja) {
                            // Jika unit kerja ditemukan, kembalikan objek unit kerja
                            return $unitKerja;
                        }

                        // Jika unit kerja tidak ditemukan, kembalikan pesan "unit kerja tidak ditemukan"
                        return $state; // Kembalikan nilai string nama unit kerja yang tidak ditemukan
                    },
                ),
        ];
    }

    // public function resolveRecord(): ?Data
    // {
    //     // return Data::firstOrNew([
    //     //     // Update existing records, matching them by `$this->data['column_name']`
    //     //     'email' => $this->data['email'],
    //     // ]);

    //     return new Data();
    // }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your data import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
