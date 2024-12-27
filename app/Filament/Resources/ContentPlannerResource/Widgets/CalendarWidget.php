<?php

namespace App\Filament\Resources\ContentPlannerResource\Widgets;

use App\Filament\Resources\ContentPlannerResource;
use App\Models\ContentPlanner;
use Filament\Widgets\Widget;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    // protected static string $view = 'filament.resources.content-planner-resource.widgets.calendar-widget';
    public function fetchEvents(array $fetchInfo): array
    {
        return ContentPlanner::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (ContentPlanner $event) => [
                    'title' => $event->id,
                    'start' => $event->starts_at,
                    'end' => $event->ends_at,
                    'url' => ContentPlannerPage::getUrl(name: 'index', parameters: ['record' => $event]),
                    'shouldOpenUrlInNewTab' => true
                ]
            )
            ->all();
    }
}
