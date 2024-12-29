<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class RegisterUser extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Master Data';

    protected static string $view = 'filament.pages.register-user';

    public $name;
    public $email;
    public $password;

    public function form(Form $form): Form
    {
        return $form

            ->schema([
                TextInput::make('name'),
                TextInput::make('email'),

                TextInput::make('password')->required(),

            ])
            ->columns(1);
    }

    public function sendAction()
    {
        return Action::make('send')
            ->label('Register')
            ->action(fn() => $this->RegisterUser());
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

            $user = User::create($userData);

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
            // Menyaring data yang dibutuhkan untuk pembuatan user

            // Membuat user baru di database
        }
    }
}
