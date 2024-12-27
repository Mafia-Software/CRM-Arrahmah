<?php

namespace App\Filament\Resources\ContentPlannerResource\Widgets;

use App\Models\ContentPlanner;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions\CreateAction;
use Saade\FilamentFullCalendar\Actions\DeleteAction;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = ContentPlanner::class;
    public function fetchEvents(array $fetchInfo): array
    {
        return ContentPlanner::query()
            ->where('tanggal', '>=', $fetchInfo['start'])
            ->get()
            ->map(
                fn (ContentPlanner $event) => [
                    'id' => $event->id,
                    'title' => $event->pesan,
                    'start' => $event->tanggal,
                ]
            )
            ->all();
    }

    protected function modalActions(): array
    {
        return [
            CreateAction::make()
                ->mountUsing(
                    function (Form $form, array $arguments) {
                        $form->fill([
                            'tanggal' => $arguments['start'] ?? null,
                        ]);
                    }
                )->createAnother(false),
            DeleteAction::make(),
        ];
    }
    public function getFormSchema(): array
    {
        return [
            RichEditor::make('pesan')->required()->toolbarButtons([
                'bold',
                'italic',
                'underline',
                'strike'
            ]),
            TextInput::make('pesan')->required(),
            FileUpload::make('media')
                ->directory('media')
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'video/mp4'])
                ->imageEditor()
                ->uploadingMessage('Mengupload Media...'),
            DatePicker::make('tanggal')->required(),
        ];
    }
    protected function headerActions(): array
    {
        return [];
    }
}
