<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use App\Models\UnitKerja;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\UnitKerjaResource\Pages;

class UnitKerjaResource extends Resource
{
    protected static ?string $model = UnitKerja::class;
    protected static ?string $navigationLabel = 'Unit Kerja';
    protected static ?string $navigationGroup = "Master Data";
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'bi-envelope-paper';

    public static function form(Form $form): Form
    {
        return $form->schema([
            //
            Section::make('Input Unit Kerja')
                ->description('')
                ->schema([TextInput::make('name')->required()->label('Unit kerja'), TextInput::make('description')->label('Description')->nullable()])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('id')->sortable()->searchable()->label('ID'),
                TextColumn::make('name')->sortable()->searchable()->label('Nama'),
                TextColumn::make('description')->sortable()->searchable()->label('Deskripsi'),
            ])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
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
            'index' => Pages\ListUnitKerjas::route('/'),
            'create' => Pages\CreateUnitKerja::route('/create'),
            'edit' => Pages\EditUnitKerja::route('/{record}/edit'),
        ];
    }
}
