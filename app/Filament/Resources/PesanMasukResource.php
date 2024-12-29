<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesanMasukResource\Pages;
use App\Models\PesanMasuk;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class PesanMasukResource extends Resource
{
    protected static ?string $model = PesanMasuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
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
                TextColumn::make('wa_server_id')->label('WA Server ID'),
                TextColumn::make('no_wa')->label('No. WhatsApp'),
                TextColumn::make('pesan')->label('Pesan'),
                ImageColumn::make('media')->label('Media'),
                TextColumn::make('created_at')->label('Dibuat')->dateTime(),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
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
