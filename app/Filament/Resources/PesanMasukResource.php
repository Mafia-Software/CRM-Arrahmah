<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesanMasukResource\Pages;
use App\Models\PesanMasuk;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
                TextColumn::make('whatsappServer.nama')->label('WA Server'),
                TextColumn::make('no_wa')->label('No. WhatsApp'),
                TextColumn::make('pesan')->label('Pesan')->limit(50),
                ImageColumn::make('media')->label('Media'),
                TextColumn::make('created_at')->label('Dibuat')->dateTime(),
            ])->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                ViewAction::make()->form([
                    TextInput::make('no_wa')->label('No. WhatsApp'),
                    Textarea::make('pesan')->label('Pesan'),
                ]),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])->emptyStateHeading('Belum Ada Pesan')
        ;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanMasuks::route('/'),
        ];
    }
}
