<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
            ['unit_kerja'=>'bangkalan'],
            ['unit_kerja'=>'Surabaya'],
            ['unit_kerja'=>'Sampang'],
            ['unit_kerja'=>'Sidoarjo'],
        ];

        DB::table('unit_kerja')->insert($data);
    }
}
