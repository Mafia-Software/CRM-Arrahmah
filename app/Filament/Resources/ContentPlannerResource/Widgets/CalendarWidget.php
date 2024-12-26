<?php

namespace App\Filament\Resources\ContentPlannerResource\Widgets;

use Filament\Widgets\Widget;
use App\Models\ContentPlanner;
use Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\ContentPlannerResource;

class CalendarWidget extends Widget
{
    // protected static string $view = 'filament.resources.content-planner-resource.widgets.calendar-widget';

    public Model | string | null $model = ContentPlanner::class;

    public function fetchEvents(array $fetchInfo): array
    {
        return ContentPlanner::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (ContentPlanner $cp) => [
                    'title' => $cp->id,
                    'start' => $cp->starts_at,
                    'end' => $cp->ends_at,
                    'url' => ContentPlannerResource::getUrl(name: 'view', parameters: ['record' => $cp]),
                    'shouldOpenUrlInNewTab' => true
                ]
            )
            ->toArray();
    }

     public function config(): array
    {
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'dayGridWeek,dayGridDay',
                'center' => 'title',
                'right' => 'prev,next today',
            ],
        ];
    }

     public static function canView(): bool
    {
        return false;
    }

public function getFormSchema(): array
{
    return [
        Forms\Components\TextInput::make('name')
            ->required(), // Misalnya, jika field name harus diisi

        // Menggunakan Grid dengan mendefinisikan kolom
        Forms\Components\Grid::make(2) // Menyusun dua kolom
            ->schema([
                Forms\Components\DateTimePicker::make('starts_at')
                    ->required(), // Menambahkan validasi jika perlu
                Forms\Components\DateTimePicker::make('ends_at')
                    ->required(), // Menambahkan validasi jika perlu
            ]),
    ];
}

}
