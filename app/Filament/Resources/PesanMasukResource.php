<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;

use App\Models\PesanMasuk;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ForceDeleteAction;
use App\Filament\Resources\PesanMasukResource\Pages;


class PesanMasukResource extends Resource
{
    protected static ?string $model = PesanMasuk::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-down';
    protected static ?string $navigationLabel = 'Pesan Masuk';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = ' Pesan Masuk';
    protected static ?string $pluralModelLabel = 'Pesan Masuk';
    protected static ?string $slug = 'pesan-masuk';
    protected static ?string $navigationGroup = 'Pesan';

    public static function form(Form $form): Form
    {
        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('whatsappServer.nama')->label('WA Server'),
                TextColumn::make('no_wa')->label('No. WhatsApp'),
                TextColumn::make('pesan')->label('Pesan'),
                ImageColumn::make('media')->label('Media'),
                TextColumn::make('created_at')->label('Dibuat')->dateTime(),
            ])->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])->emptyStateHeading('Belum Ada Pesan');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanMasuks::route('/'),
        ];
    }
}
