<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContentPlannerResource\Pages;
use App\Filament\Resources\ContentPlannerResource\RelationManagers;
use App\Models\ContentPlanner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
