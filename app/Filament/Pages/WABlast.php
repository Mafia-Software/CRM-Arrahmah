<?php

namespace App\Filament\Pages;

use App\Http\Controllers\API\WhatsappController;
use App\Models\User;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Models\UnitKerja;
use Filament\Tables\Table;
use App\Models\ContentPlanner;
use App\Models\History;
use App\Models\WhatsappServer;
use App\Services\WhatsappService;
use Filament\Actions\Action as ActionsAction;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithRecord;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use PhpParser\Node\Stmt\Break_;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\CheckboxColumn;


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
    public $selectedUser;
    public $selectedContentPlanner;
    public $selectedWhatsappServer;
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
                    Select::make('selectedUser')
                        ->label('User')
                        ->options(User::all()->pluck('name', 'id'))
                        ->default(null)
                        ->columnSpan([
                            'sm' => 2,
                            'xl' => 3,
                            '2xl' => 4,
                        ])
                        ->reactive()->required(),
                    Select::make('selectedUnitKerja')
                        ->label('Unit Kerja')
                        ->options(UnitKerja::all()->pluck('name', 'id'))
                        ->default(null)
                        ->columnSpan([
                            'sm' => 2,
                            'xl' => 3,
                            '2xl' => 4,
                        ])
                        ->reactive(),
                    Select::make('selectedContentPlanner')
                        ->label('Content Planner')
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
                            'sm' => 2,
                            'xl' => 3,
                            '2xl' => 4,
                        ])
                        ->reactive()->required(),
                    TextInput::make('startId')
                        ->label('ID Mulai')
                        ->numeric()
                        ->columnSpan([
                            'sm' => 2,
                            'xl' => 3,
                            '2xl' => 4,
                        ])
                        ->reactive(),
                    TextInput::make('endId')
                        ->label('ID Akhir')
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

    public $selectedIds = [];
    public function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('id')->label('ID'),
            TextColumn::make('nama'),
            TextColumn::make('alamat'),
            TextColumn::make('no_wa')->label('No. Whatsapp'),
            CheckboxColumn::make('selected')
            ->label('Pilih')
            ->toggleable() // Agar bisa diaktifkan/nonaktifkan
            ->default(false) // Secara default tidak tercentang
            ->getStateUsing(fn ($record) => $record->selected === 1 || $record->selected === null)
            ->afterStateUpdated(function ($state, $record) {
                // Logika untuk mengelola array $selectedIds ketika checkbox diubah
                // (Jika diperlukan)
            }),
            ])

            ->emptyStateHeading('Silahkan Pilih Unit Kerja dan User')
            ->query(function () {
                return Customer::when(
                    is_null($this->selectedUser),
                    fn ($query) => $query,
                    fn ($query) => $query
                        ->when(
                            $this->startId && $this->endId,
                            fn ($query) => $query->whereBetween('id', [$this->startId, $this->endId]),
                            fn ($query) => $query
                        )
                        ->when(
                            $this->selectedUnitKerja && $this->selectedUnitKerja !== 'Semua',
                            fn ($query) => $query->where('unit_kerja_id', $this->selectedUnitKerja),
                            fn ($query) => $query
                        )
                );
            })
            ->actions([
                // DeleteAction::make()
                //     ->action(function (DeleteAction $action) use ($table) {
                //         $recordId = $action->getRecord()->id;
                //     }),
            ]);
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

    $customers = Customer::select('id', 'no_wa')
        ->where('user_id', $this->selectedUser)
        ->when(
            $this->selectedUnitKerja,
            fn ($query) => $query->where('unit_kerja_id', $this->selectedUnitKerja),
            fn ($query) => $query
        )
        ->whereIn('selected', [1, null]);

    if ($this->startId && $this->endId) {
        $customers = $customers->whereBetween('id', [$this->startId, $this->endId]);
    }

    $customers = $customers->get();

    $ContentPlanner = ContentPlanner::where('id', $this->selectedContentPlanner)->first();
    $WhatsappServer = WhatsappServer::where('id', $this->selectedWhatsappServer)->first();

    switch (is_null($ContentPlanner->media)) {
        case true:
            $wa = new WhatsappController(new WhatsappService);
            $wa->sendMessage($WhatsappServer, $customers, $ContentPlanner);
            Notification::make()->success()->title('Berhasil')->body('Pesan Berhasil Diproses')->send();
            break;
        case false:
            $wa = new WhatsappController(new WhatsappService);
            $wa->sendMessageMedia($WhatsappServer, $customers, $ContentPlanner);
            Notification::make()->success()->title('Berhasil')->body('Pesan Berhasil Diproses')->send();
            break;
    }
}

    public function getSelectedValidation()
    {
        return $this->selectedUser && $this->selectedContentPlanner && $this->selectedWhatsappServer;
    }
}
