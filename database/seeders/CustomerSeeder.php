<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            [
                'nama' => 'abdul',
                'no_wa' => '08123123123',
                'unit_kerja_id' => "2", // Gunakan Hash::make untuk mengenkripsi password
            ],
            [
                'nama' => 'rijal slebew',
                'no_wa' => '081231231993',
                'unit_kerja_id' => "5", // Gunakan Hash::make untuk mengenkripsi password
            ],
            [
                'nama' => 'alfianto racing blarblarr',
                'no_wa' => '0817768763',
                'unit_kerja_id' => "4", // Gunakan Hash::make untuk mengenkripsi password
            ],
            [
                'nama' => 'rusday',
                'no_wa' => '0899231993',
                'unit_kerja_id' => "1", // Gunakan Hash::make untuk mengenkripsi password
            ],
        ];
        DB::table('customers')->insert($data);
    }
}