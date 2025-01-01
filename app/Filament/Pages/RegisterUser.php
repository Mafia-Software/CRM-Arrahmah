<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithRecord;
use Filament\Actions\Concerns\InteractsWithActions;

class RegisterUser extends Page implements HasTable, HasForms, HasActions
{
    use InteractsWithTable;
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithRecord;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.register-user';

    public $name;
    public $email;
    public $password;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->label('Nama'),
                TextInput::make('email')->required()->email()->label('Email'),
                TextInput::make('password')->password()->required(),
            ])
            ->columns(3);
    }

    public function sendAction()
    {
        return Action::make('send')
            ->label('Register')
            ->action(fn() => $this->RegisterUser());;
    }

    public function RegisterUser()
    {
        $data = $this->form->getState();
        $validatedData = validator($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string'], // Pastikan password valid
        ])->validate(); // Jika validasi gagal, Laravel akan otomatis mengeluarkan pesan error
        try {
            $userData = [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),  // Pastikan password di-hash
            ];
            User::create($userData);
            Notification::make()
                ->title('Registrasi Berhasil')
                ->body('User telah berhasil terdaftar.')
                ->success() // Menampilkan notifikasi sukses
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Registrasi Gagal')
                ->body('User Gagal terdaftar, Coba Lagi')
                ->danger() // Menampilkan notifikasi sukses
                ->send();
        }
    }
    public function table(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('name')->label('Nama'),
                TextColumn::make('email'),
            ])
            ->query(function () {
                return User::query();
            });
    }
}
