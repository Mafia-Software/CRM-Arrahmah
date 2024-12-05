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
        ];


        DB::table('users')->insert($data);
    }
}
