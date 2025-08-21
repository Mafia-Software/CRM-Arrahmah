<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesanKeluarResource\Pages;
use App\Models\PesanKeluar;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PesanKeluarResource extends Resource
{
    protected static ?string $model = PesanKeluar::class;
    protected static ?string $modelLabel = ' Pesan Keluar';
    protected static ?string $pluralModelLabel = 'Pesan Keluar';
    protected static ?int $navigationSort = 3;
    protected static ?string $slug = 'pesan-keluar';
    protected static ?string $navigationGroup = 'Pesan';
    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';

    public static function form(Form $form): Form
    {
        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.nama')
                    ->searchable()->label('Customer'),
                TextColumn::make('history_id')
                    ->searchable()->label('History'),
                TextColumn::make('status')
                    ->label('Status')->badge()->color(fn (string $state): string => match ($state) {
                        'Terkirim' => 'warning',
                        'Terkirim & Masuk' => 'warning',
                        'Terbaca' => 'success',
                        'Error' => 'danger',
                    })->getStateUsing(fn ($record) => match ($record->status) {
                        '200' => 'Terkirim',
                        '2' => 'Terkirim',
                        '3' => 'Terkirim & Masuk',
                        '4' => 'Terbaca',
                        default => 'Error',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Tanggal'),
            ])->defaultSort('created_at', 'desc')
            ->filters([
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
        ;
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanKeluars::route('/'),
        ];
    }
}
