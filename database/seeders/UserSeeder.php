<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'mamat',
                'email' => 'mamat@a.com',
                'password' => Hash::make('mamat'), // Gunakan Hash::make untuk mengenkripsi password
            ],
            [
                'name' => 'rusdi',
                'email' => 'rusdi@a.com',
                'password' => Hash::make('rusdi'), // Gunakan Hash::make untuk mengenkripsi password
            ],
        ];


        foreach ($data as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']], // Kondisi unik untuk pencarian
                [
                    'name' => $user['name'],
                    'password' => $user['password'],
                    'updated_at' => now(), // Tambahkan waktu pembaruan
                ]
            );
        }
    }
}
