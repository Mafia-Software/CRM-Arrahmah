<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ContentPlanner;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ContentPlannerResource\Pages;
use App\Filament\Resources\ContentPlannerResource\RelationManagers;

class ContentPlannerResource extends Resource
{
    protected static ?string $model = ContentPlanner::class;

    protected static ?string $navigationIcon = 'bi-graph-up-arrow';
    protected static ?string $navigationLabel = "Content Planner";
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Content Planner')
                    ->description('')
                    ->schema([
                        TextInput::make('pesan')->required(),
                    ])
                    ->columns(1),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                 TextColumn::make('id')->sortable()->searchable()->label('ID'),
                TextColumn::make('pesan')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListContentPlanners::route('/'),
            'create' => Pages\CreateContentPlanner::route('/create'),
            'edit' => Pages\EditContentPlanner::route('/{record}/edit'),
        ];
    }
}
