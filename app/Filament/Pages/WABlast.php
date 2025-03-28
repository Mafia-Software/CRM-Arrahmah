<?php

namespace App\Filament\Pages;

use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Models\UnitKerja;
use Filament\Tables\Table;
use App\Models\ContentPlanner;
use App\Models\WhatsappServer;
use App\Services\WhatsappService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\Action as ActionsAction;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Http\Controllers\API\WhatsappController;
use App\Models\OrderedData;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithRecord;
use Filament\Actions\Concerns\InteractsWithActions;
use Illuminate\Support\Facades\DB;

class WABlast extends Page implements HasTable, HasForms, HasActions
{
    use InteractsWithTable;
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithRecord;
    protected static ?string $navigationIcon = 'bi-envelope-arrow-up-fill';
    protected static ?int $navigationSort = 1;
    protected static ?string $slug = 'wablast';
    protected static ?string $title = 'WA Blast';
    protected static ?string $navigationGroup = 'Pesan';
    protected static string $view = 'filament.pages.wablast';

    public $selectedUnitKerja;
    public $selectedWhatsappServer;
    public $selectedContentPlanner;
    public $startId;
    public $endId;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')->columns([
                    'sm' => 3,
                    'xl' => 6,
                    '2xl' => 8,
                ])->schema([
                    Select::make('selectedUnitKerja')
                        ->label('Unit Kerja')
                        ->options(UnitKerja::all()->pluck('name', 'id'))
                        ->default(null)
                        ->columnSpan([
                            'sm' => 2,
                            'xl' => 3,
                            '2xl' => 4,
                        ])
                        ->reactive()
                        ->required(),
                    Select::make('selectedContentPlanner')
                        ->label('Content Planner')->searchable()
                        ->options(ContentPlanner::all()->pluck('tanggal', 'id'))
                        ->default(null)
                        ->columnSpan([
                            'sm' => 2,
                            'xl' => 3,
                            '2xl' => 4,
                        ])
                        ->reactive()->required(),
                    Select::make('selectedWhatsappServer')
                        ->label('Whatsapp Server')
                        ->options(WhatsappServer::query()->where('service_status', 'CONNECTED')->pluck('nama', 'id'))
                        ->default(null)
                        ->columnSpan([
                            'sm' => 12,
                            'xl' => 6,
                            '2xl' => 8,
                        ])
                        ->reactive()->required(),
                    TextInput::make('startId')
                        ->label('Nomor Mulai')
                        ->numeric()
                        ->columnSpan([
                            'sm' => 2,
                            'xl' => 3,
                            '2xl' => 4,
                        ])
                        ->reactive(),
                    TextInput::make('endId')
                        ->label('Nomor Akhir')
                        ->numeric()
                        ->columnSpan([
                            'sm' => 2,
                            'xl' => 3,
                            '2xl' => 4,
                        ])
                        ->reactive(),
                ])
            ]);
    }
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->label('No')->rowIndex(),
                TextColumn::make('nama')->searchable(),
                TextColumn::make('alamat')->searchable(),
                TextColumn::make('unitKerja.name')->label('Unit Kerja')->searchable(),
                TextColumn::make('no_wa')->label('No. Whatsapp')->searchable(),
            ])
            ->emptyStateHeading('Tidak ada Data')
            ->query(function () {
                $viewQuery = DB::table('ordered_data');
                $viewQuery->where('unit_kerja_id', $this->selectedUnitKerja);

                if ($this->startId && $this->endId) {
                    $viewQuery->where('unit_kerja_index', '>=', $this->startId);
                    $viewQuery->where('unit_kerja_index', '<=', $this->endId);
                }

                $customerIds = $viewQuery->pluck('id')->toArray();
                $customerQuery = Customer::query();

                if (!empty($customerIds)) {
                    $customerQuery->whereIn('id', $customerIds);
                } else {
                    $customerQuery->whereRaw('1=0');
                }
                return $customerQuery;
            });
    }
    public function sendAction()
    {
        return ActionsAction::make('send')
            ->label('Kirim Pesan')
            ->action(fn() => $this->sendMessage());
    }

    public function sendMessage()
    {
        if (!$this->getSelectedValidation()) {
            Notification::make()
                ->warning()
                ->title('Validasi Gagal')
                ->body('Pastikan semua dropdown telah dipilih.')
                ->send();
            return;
        }

        $customers = OrderedData::select('id', 'no_wa');

        $customers = $customers->where('unit_kerja_id', $this->selectedUnitKerja);

        if ($this->startId && $this->endId) {
            $customers = $customers->where('unit_kerja_index', '>=', $this->startId);
            $customers = $customers->where('unit_kerja_index', '<=', $this->endId);
        }

        $customers = $customers->get();
        $ContentPlanner = ContentPlanner::where('id', $this->selectedContentPlanner)->first();
        $whatsappServer = WhatsappServer::where('id', $this->selectedWhatsappServer)->first();
        switch (is_null($ContentPlanner->media)) {
            case true:
                $wa = new WhatsappController(new WhatsappService);
                $wa->sendMessage($customers, $ContentPlanner, $whatsappServer);
                Notification::make()->success()->title('Berhasil')->body('Pesan Berhasil Diproses')->send();
                break;
            case false:
                $wa = new WhatsappController(new WhatsappService);
                $wa->sendMessageMedia($customers, $ContentPlanner, $whatsappServer);
                Notification::make()->success()->title('Berhasil')->body('Pesan Berhasil Diproses')->send();
                break;
        }
    }

    public function getSelectedValidation()
    {
        return $this->selectedContentPlanner && $this->selectedWhatsappServer;
    }
}
