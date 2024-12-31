<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
            ['name' => 'BMA'],
            ['name' => 'STIDKI'],
            ['name' => 'BADR'],
            ['name' => 'AQIQOH'],
            ['name' => 'EVENT'],
            ['name' => 'UMUM'],
            ['name' => 'KELUARGA'],
        ];

        DB::table('unit_kerjas')->insert($data);
    }
}
