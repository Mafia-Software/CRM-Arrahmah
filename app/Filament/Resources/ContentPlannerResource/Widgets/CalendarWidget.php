<?php

namespace App\Filament\Resources\ContentPlannerResource\Widgets;

use App\Models\ContentPlanner;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
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
                function (ContentPlanner $event) {
                    return [
                        'id' => $event->id,
                        'title' => $this->whatsappToHtml($event->pesan),
                        'start' => $event->tanggal,
                    ];
                }
            )
            ->all();
    }
    function whatsappToHtml($text)
    {
        $text = preg_replace('/\*(.+?)\*/', '$1', $text);
        $text = preg_replace('/_(.+?)_/', '$1', $text);
        $text = preg_replace('/~(.*?)~/', '$1', $text);
        return $text;
    }
    function htmlToWhatsapp($text)
    {
        $markdown = str_replace(['<strong>', '</strong>'], ['*', '*'], $text);
        $markdown = str_replace(['<em>', '</em>'], ['_', '_'], $markdown);
        $markdown = str_replace(['<del>', '</del>'], ['~', '~'], $markdown);
        $markdown = str_replace(['<p>', '</p>'], ["", "\n"], $markdown);
        $markdown = rtrim($markdown, "\n");
        return $markdown;
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
                )->createAnother(false)->mutateFormDataUsing(
                    function (array $data): array {
                        $data['pesan'] = $this->htmlToWhatsapp($data['pesan']);
                        return $data;
                    }
                )->before(function ($data, $action) {
                    $contentPlanner = ContentPlanner::where('tanggal', $data['tanggal'])->first();
                    if ($contentPlanner) {
                        Notification::make()->danger()->title('Error')->body('Tanggal Sudah Terisi')->send();
                        $action->cancel();
                    }
                }),
            DeleteAction::make(),
        ];
    }
    public function getFormSchema(): array
    {
        return [
            RichEditor::make('pesan')->required()->toolbarButtons([
                'bold',
                'italic',
                'strike'
            ]),
            FileUpload::make('media')
                ->directory('media')
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'video/mp4'])
                ->imageEditor()
                ->visibility('public')
                ->uploadingMessage('Mengupload Media...'),
            DatePicker::make('tanggal')->required()->readOnly(),
        ];
    }
    protected function headerActions(): array
    {
        return [];
    }
}
