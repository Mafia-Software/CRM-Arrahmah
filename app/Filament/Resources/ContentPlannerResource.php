<?php

namespace App\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use App\Filament\Resources\ContentPlannerResource\Pages;
use App\Filament\Resources\ContentPlannerResource\Widgets\CalendarWidget;
use Filament\Tables\Table;

class ContentPlannerResource extends Resource
{
    protected static ?string $navigationIcon = 'bi-graph-up-arrow';
    protected static ?string $navigationLabel = "Content Planner";
    protected static ?int $navigationSort = 3;
    public static function form(Form $form): Form
    {
        return $form;
    }
    public static function table(Table $table): Table
    {
        return $table;
    }

    public static function getWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
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
            // 'index' => Pages\ContentPlannerPage::route('/'),
        ];
    }
}
