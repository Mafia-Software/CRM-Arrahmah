<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use App\Filament\Resources\CustomerResource\Pages;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'bi-person-fill-gear';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->schema([
                    TextInput::make('nama'),
                    TextInput::make('alamat'),
                    TextInput::make('no_wa')
                        ->required()
                        ->label('No. Whatsapp')
                        ->rule(function ($get) {
                            return function ($attribute, $value, $fail) use ($get) {
                                $unitKerjaId = $get('unit_kerja_id');
                                $existing = Customer::where('no_wa', $value)->where('unit_kerja_id', $unitKerjaId)->exists();

                                if ($existing) {
                                    $fail('Nomor WhatsApp ini sudah digunakan di unit kerja yang sama.');
                                }
                            };
                        }),
                    Select::make('unit_kerja_id')->label('Unit Kerja')->relationship('UnitKerja', 'name')->required(),
                    Select::make('response')->relationship('response', 'name'),
                    Select::make('user_id')->label('User')->relationship('user', 'name'),
                ])
                ->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('id')->sortable()->searchable()->label('ID'),
                TextColumn::make('nama')->sortable()->searchable(),
                TextColumn::make('alamat')->sortable()->searchable(),
                TextColumn::make('no_wa')->sortable()->searchable()->label('No. Whatsapp'),
                TextColumn::make('unitKerja.name')->sortable()->searchable()->label('Unit Kerja'),
                TextColumn::make('response.name')->sortable()->searchable()->label('Response'),
                TextColumn::make('user.name')->sortable()->searchable()->label('User'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
                TrashedFilter::make(),
                SelectFilter::make('unit_kerja')->label('Unit kerja')->relationship('unitKerja', 'name'),

                SelectFilter::make('response')->label('Response')->relationship('response', 'name'),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make(), Tables\Actions\RestoreAction::make(), Tables\Actions\ForceDeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make(), Tables\Actions\ForceDeleteBulkAction::make(), Tables\Actions\RestoreBulkAction::make()])])
            ->emptyStateHeading('Belum Ada Data Customer');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
