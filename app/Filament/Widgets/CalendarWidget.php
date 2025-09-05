<?php

namespace App\Filament\Widgets;

use App\Models\ContentPlanner;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Saade\FilamentFullCalendar\Actions\CreateAction;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public null|Model|string $model = ContentPlanner::class;

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
            ->all()
        ;
    }

    public function whatsappToHtml($text)
    {
        $text = preg_replace('/\*(.+?)\*/', '$1', $text);
        $text = preg_replace('/_(.+?)_/', '$1', $text);

        return preg_replace('/~(.*?)~/', '$1', $text);
    }

    public function htmlToWhatsapp($text)
    {
        $markdown = str_replace(['<strong>', '</strong>'], ['*', '*'], $text);
        $markdown = str_replace(['<em>', '</em>'], ['_', '_'], $markdown);
        $markdown = str_replace(['<del>', '</del>'], ['~', '~'], $markdown);
        $markdown = str_replace(['<p>', '</p>'], ['', "\n"], $markdown);
        $markdown = str_replace(['<br>'], ["\n"], $markdown);
        $markdown = str_replace(['&nbsp;'], [''], $markdown);

        return rtrim($markdown, "\n");
    }

    public function getFormSchema(): array
    {
        return [
            RichEditor::make('pesan')->required()->toolbarButtons([
                'bold',
                'italic',
                'strike',
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
            Action::make('delete')->label('Hapus')->color('danger')->icon('heroicon-s-trash')->action(
                function (ContentPlanner $record, $action, FullCalendarWidget $livewire) {
                    if ($record->media) {
                        Storage::disk('public')->delete($record->media);
                    }
                    $record->forceDelete();
                    Notification::make()->success()->title('Berhasil')->body('Data Berhasil Dihapus')->send();
                    $livewire->refreshRecords();
                    $action->cancelParentActions();
                }
            ),
        ];
    }

    protected function headerActions(): array
    {
        return [];
    }
}
