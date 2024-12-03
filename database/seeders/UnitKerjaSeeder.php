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
            ['name' => 'bangkalan'],
            ['name' => 'Surabaya'],
            ['name' => 'Sampang'],
            ['name' => 'Sidoarjo'],
        ];

        DB::table('unit_kerjas')->insert($data);
    }
}
