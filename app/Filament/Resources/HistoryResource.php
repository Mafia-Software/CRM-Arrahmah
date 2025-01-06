<?php

namespace App\Filament\Resources;

use App\Models\History;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use App\Filament\Resources\HistoryResource\Pages;
use RyanChandler\FilamentProgressColumn\ProgressColumn;
use Illuminate\Support\Facades\Bus;

class HistoryResource extends Resource
{
    protected static ?string $model = History::class;

    protected static ?string $navigationIcon = 'heroicon-m-arrow-uturn-left';
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Pesan';
    protected static ?string $navigationLabel = 'Riwayat Blast';

    public static function form(Form $form): Form
    {
        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('user.name')->label('Admin'),
                TextColumn::make('whatsappServer.nama')->label('WA Server'),
                ProgressColumn::make('progress')->label('Progress')->color('bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500')->progress(function ($record) {
                    return Bus::findBatch($record->batch_id)->progress();
                }),
                TextColumn::make('contentPlanner.pesan')->label('Pesan')->limit(100),
                TextColumn::make('created_at')->label('Tanggal'),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->emptyStateHeading('Belum Ada Riwayat');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHistories::route('/'),
        ];
    }
}
