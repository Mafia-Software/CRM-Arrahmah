<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesanKeluarResource\Pages;
use App\Models\PesanKeluar;
use Filament\Forms;
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
    protected static ?int $navigationSort = 4;
    protected static ?string $slug = 'pesan-keluar';
    protected static ?string $navigationGroup = 'Pesan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('history_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_id')
                    ->searchable()->label('Customer ID'),
                TextColumn::make('history_id')
                    ->searchable()->label('History ID'),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanKeluars::route('/'),
        ];
    }
}
