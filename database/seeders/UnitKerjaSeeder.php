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
            ['id' => 1, 'unit_kerja'=>'bangkalan'],
            ['id' => 2, 'unit_kerja'=>'Surabaya'],
            ['id' => 3, 'unit_kerja'=>'Sampang'],
            ['id' => 4, 'unit_kerja'=>'Sidoarjo'],
        ];

        DB::table('unit_kerja')->insert($data);
    }
}
