<?php

namespace App\Filament\Pages;

use App\Models\ContentPlanner;
use App\Models\Customer;
use App\Models\UnitKerja;
use Filament\Actions\Concerns\InteractsWithRecord;
use Filament\Tables\Actions\DeleteAction;
use Filament\Pages\Page;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;


class WABlast extends Page implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithRecord;
    protected static ?string $navigationIcon = 'bi-envelope-arrow-up-fill';
    protected static ?int $navigationSort = 1;
    protected static ?string $slug = 'wablast';
    protected static ?string $title = 'WA Blast';
    protected static ?string $navigationGroup = 'Pesan';
    protected static string $view = 'filament.pages.wablast';

    public $selectedUnitKerja;

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
                        ->columnSpan([
                            'sm' => 2,
                            'xl' => 3,
                            '2xl' => 4,
                        ])
                        ->reactive(),
                    Select::make('selectedContentPlanner')
                        ->label('Content Planner')
                        ->options(ContentPlanner::all()->pluck('pesan', 'id'))
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
                TextColumn::make('id')->label('ID'),
                TextColumn::make('nama'),
                TextColumn::make('alamat'),
                TextColumn::make('no_wa')->label('No. Whatsapp'),
            ])
            ->query(function () {
                return Customer::where('unit_kerja_id', $this->selectedUnitKerja);
            })
            ->actions([
                DeleteAction::make()
                    ->action(function (DeleteAction $action) use ($table) {
                        $recordId = $action->getRecord()->id;
                    }),
            ]);
    }

    public function sendMessage()
    {
        dd($this->table->getRecords()->toArray());
    }
    public $UnitKerja;
    public $ContentPlanner;
}
