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
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;

class WhatsAppServerResource extends Resource
{
    protected static ?string $model = WhatsappServer::class;
    protected static ?string $navigationLabel = 'Whatsapp Server';
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
                TextInput::make('delay')->label('Delay')->suffix('Detik')->required()->numeric(),
                TextInput::make('delaybatch')->label('Delay/Batch')->suffix('Menit')->required()->numeric(),
                TextInput::make('jumlahbatch')->label('Jumlah Batch')->required()->numeric(),
            ])
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama'),
                TextColumn::make('no_wa')->label('No. Whatsapp'),
                TextColumn::make('delay')->suffix(' detik'),
                TextColumn::make('delaybatch')->label('Delay/Batch')->suffix(' menit'),
                TextColumn::make('jumlahbatch')->label('Jumlah Batch'),
                TextColumn::make('service_status')->label('Status')->badge()->color(fn (string $state): string => match ($state) {
                    'SERVICE_OFF' => 'gray',
                    'PAIRING' => 'warning',
                    'SERVICE_SCAN' => 'warning',
                    'SERVICE_ON' => 'success',
                    'CONNECTED' => 'success',
                }),
            ])->poll('5s')
            ->actions([
                ActionGroup::make([
                    Action::make('start')
                        ->label('Mulai')
                        ->color('success')
                        ->icon('heroicon-s-play')
                        ->action(function ($record) {
                            $wa = new WhatsappController(new WhatsappService());
                            $wa->startService($record->api_key);
                        })->after(function ($record) {
                            $record->refresh();
                        })
                        ->hidden(fn ($record) => 'SERVICE_OFF' !== $record->service_status),
                    Action::make('pair')
                        ->label('Scan QR')
                        ->color('gray')
                        ->icon('heroicon-o-qr-code')
                        ->modalContent(function ($record): View {
                            $wa = new WhatsappController(new WhatsappService());
                            $qr = $wa->getQR($record->api_key);
                            if (200 == $qr->getData()->status) {
                                $qrCode = substr($qr->getData()->qr, strpos($qr->getData()->qr, ',') + 1);
                                session()->put('qr', $qrCode);
                                $qrCode = session()->get('qr');
                                session()->forget('qr');

                                return view('filament.pages.components.qr-modal', ['qr' => $qrCode]);
                            }
                            Notification::make()
                                ->title('Gagal Mendapatkan QR')
                                ->body($qr->getData()->message)
                                ->danger()
                                ->send()
                            ;
                            session()->put('qr', $qr->getData()->message);
                            $message = session()->get('qr');
                            session()->forget('qr');

                            return view('filament.pages.components.qr-modal', ['message' => $message]);
                        })->modalAlignment('center')
                        ->modalWidth('sm')
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false)
                        ->hidden(function ($record) {
                            if ('SERVICE_SCAN' != $record->service_status && 'PAIRING' != $record->service_status) {
                                return true;
                            }
                        }),
                    Action::make('stop')
                        ->label('Hentikan')
                        ->color('danger')
                        ->icon('heroicon-s-stop')
                        ->action(function ($record) {
                            $wa = new WhatsappController(new WhatsappService());
                            $wa->stopService($record->api_key);
                        })
                        ->after(function ($record) {
                            $record->refresh();
                        })
                        ->hidden(fn ($record) => 'SERVICE_OFF' === $record->service_status),
                    EditAction::make(),
                    DeleteAction::make()->before(function (DeleteAction $action, $record) {
                        $wa = new WhatsappController(new WhatsappService());
                        $res = $wa->deleteDevice($record->api_key);
                        if (true != $res->getData()->status) {
                            Notification::make()->danger()->title('Error')->body($res->getData()->message)->send();
                            $action->cancel();
                        }
                    }),
                ]),
            ])
            ->bulkActions([])
            ->emptyStateHeading('Belum Ada Whatsapp Server')
        ;
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
