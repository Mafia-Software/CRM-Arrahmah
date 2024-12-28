<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Response;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\ResponseResource\Pages;

class ResponseResource extends Resource
{
    protected static ?string $model = Response::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'bi-graph-up-arrow';
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Input Response')
                ->description('')
                ->schema([TextInput::make('name')->required()->label('Name'), TextInput::make('code')->label('Code')->nullable()])
                ->columns(2),
            //
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable()->label('ID'),
                TextColumn::make('name')->sortable()->searchable()->label('Nama'),
                TextColumn::make('code')->sortable()->searchable()->label('Kode'),
                //
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
            'index' => Pages\ListResponses::route('/'),
            'create' => Pages\CreateResponse::route('/create'),
            'edit' => Pages\EditResponse::route('/{record}/edit'),
        ];
    }
}
