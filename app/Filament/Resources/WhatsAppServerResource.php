<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhatsAppServerResource\Pages;
use App\Models\WhatsappServer;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class WhatsAppServerResource extends Resource
{
    protected static ?string $model = WhatsappServer::class;
    protected static ?string $navigationLabel = "Whatsapp Server";
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('no_wa')->label('No. Whatsapp')->required()->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('no_wa')
                    ->searchable(),
                TextColumn::make('instance_id')
                    ->searchable()->label('Instance ID'),
                IconColumn::make('is_active')->boolean()->label('Status'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('connect')
                        ->label(fn($record) => match ($record->is_active) {
                            0 => 'Scan QR',
                            1 => 'Putuskan',
                            default => null,
                        })
                        ->url(fn($record) => match ($record->is_active) {
                            default => null,
                        })
                        ->icon(fn($record) => match ($record->is_active) {
                            0 => 'heroicon-o-qr-code',
                            1 => 'heroicon-o-x-circle',
                            default => null,
                        }),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWhatsAppServers::route('/'),
            'create' => Pages\CreateWhatsAppServer::route('/create'),
            'edit' => Pages\EditWhatsAppServer::route('/{record}/edit'),
        ];
    }
}
