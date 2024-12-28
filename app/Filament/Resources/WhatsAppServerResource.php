<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhatsAppServerResource\Pages;
use App\Http\Controllers\API\WhatsappController;
use App\Models\WhatsappServer;
use App\Services\WhatsappService;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class WhatsAppServerResource extends Resource
{
    protected static ?string $model = WhatsappServer::class;
    protected static ?string $navigationLabel = "Whatsapp Server";
    protected static ?string $slug = 'whatsapp-servers';

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
                TextInput::make('delay')->label('delay'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('no_wa')->label('No. Whatsapp')
                    ->searchable(),
                // TextColumn::make('instance_id')
                //     ->searchable()->label('Instance ID'),
                TextColumn::make('delay'),
                TextColumn::make('service_status')->label('Status')->badge()->color(fn(string $state): string => match ($state) {
                    'SERVICE_OFF' => 'gray',
                    'SERVICE_SCAN' => 'warning',
                    'SERVICE_ON' => 'success',
                }),
                IconColumn::make('is_active')->boolean()->label('Terhubung?'),
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
                    Action::make('start')
                        ->label('Mulai')
                        ->color('success')
                        ->icon('heroicon-s-play')
                        ->action(function ($record) {
                            $wa = new WhatsappController(new WhatsappService());
                            $wa->startService($record->api_key);
                            $state = $wa->getState($record->api_key);
                            $record->update(['service_status' => $state['results']['state']]);
                        })
                        ->hidden(fn($record) => $record->service_status !== 'SERVICE_OFF')->after(fn() => $table->dispatch('refresh')),
                    Action::make('pair')
                        ->label('Scan QR')
                        ->color('gray')
                        ->icon('heroicon-o-qr-code')
                        ->modalContent(function ($record): View {
                            $wa = new WhatsappController(new WhatsappService());
                            $qr = $wa->getQR($record->api_key);
                            if ($qr->getData()->status == 200) {
                                $qrCode = substr($qr->getData()->qr, strpos($qr->getData()->qr, ',') + 1);
                                session()->put('qr', $qrCode);
                            } else {
                                Notification::make()
                                    ->title('Gagal Mendapatkan QR')
                                    ->danger()
                                    ->send();
                            }
                            $qrCode = session()->get('qr');
                            session()->forget('qr');
                            return view('filament.pages.components.qr-modal', ['qr' => $qrCode]);
                        })->modalAlignment('center')
                        ->modalWidth('sm')
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false)
                        ->hidden(fn($record) => $record->service_status !== 'SERVICE_SCAN'),
                    Action::make('stop')
                        ->label('Hentikan')
                        ->color('danger')
                        ->icon('heroicon-s-stop')
                        ->hidden(fn($record) => $record->service_status !== 'SERVICE_ON'),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->emptyStateHeading('Belum Ada Whatsapp Server');
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
