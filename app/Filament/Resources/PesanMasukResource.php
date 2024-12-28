<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesanMasukResource\Pages;
use App\Filament\Resources\PesanMasukResource\RelationManagers;
use App\Models\PesanMasuk;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PesanMasukResource extends Resource
{
    protected static ?string $model = PesanMasuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Pesan Masuk';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = ' Pesan Masuk';
    protected static ?string $pluralModelLabel = 'Pesan Masuk';
    protected static ?string $slug = 'custom-url-slug';
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
            'edit' => Pages\EditPesanMasuk::route('/{record}/edit'),
        ];
    }
}
