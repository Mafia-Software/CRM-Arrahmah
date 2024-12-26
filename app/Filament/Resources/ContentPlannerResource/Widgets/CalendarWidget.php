<?php

namespace App\Filament\Resources\ContentPlannerResource\Widgets;

use Filament\Widgets\Widget;
use App\Models\ContentPlanner;
use Forms\Components\TextInput;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Grid;
use Illuminate\Database\Eloquent\Model;

use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\ContentPlannerResource;
use Saade\FilamentFullCalendar\Actions\CreateAction;
use Saade\FilamentFullCalendar\Actions\DeleteAction;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    // protected static string $view = 'filament.resources.content-planner-resource.widgets.calendar-widget';
      protected static string $view = 'filament.resources.content-planner-resource.widgets.calendar-widget';

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

protected function headerActions(): array
    {
        return [
            CreateAction::make()
            ->mountUsing(function ($form, $arguments) {
                $form->fill([
                    'starts_at' => $arguments['start'] ?? null,
                    'ends_at' => $arguments['end'] ?? null,
                ]);
            }),
        ];
    }

    protected function modalActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }

    public function eventDidMount(): string
{
    return <<<JS
        function({ event, el }) {
            el.title = event.title;
        }
    JS;
}

}
