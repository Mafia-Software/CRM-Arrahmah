<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesanMasukResource\Pages;
use App\Filament\Resources\PesanMasukResource\RelationManagers;
use App\Models\PesanMasuk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PesanMasukResource extends Resource
{
    protected static ?string $model = PesanMasuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-alt';
    protected static ?string $navigationLabel = 'Pesan Masuk';
    protected static ?string $navigationGroup = 'Manajemen Pesan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('wa_server_id')
                    ->label('WA Server ID')

                    ->required(),
                Forms\Components\TextInput::make('no_wa')
                    ->label('Nomor WhatsApp')
                    ->required()
                    ->maxLength(15),
                Forms\Components\Textarea::make('pesan')
                    ->label('Pesan')
                    ->required()
                    ->maxLength(500),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('ws_server_id')->label('WA Server ID'),
                Tables\Columns\TextColumn::make('no_wa')->label('Nomor WhatsApp'),
                Tables\Columns\TextColumn::make('pesan')->label('Pesan'),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime(),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanMasuks::route('/'),
            'create' => Pages\CreatePesanMasuk::route('/create'),
            'edit' => Pages\EditPesanMasuk::route('/{record}/edit'),
        ];
    }
}
