<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW ordered_data AS
            SELECT
                c.id,
                c.unit_kerja_id,
                u.name AS unit_kerja_nama,  -- The unit kerja name from the joined table
                c.nama AS customer_nama,  -- Customer name
                c.alamat,
                c.no_wa,
                ROW_NUMBER() OVER (PARTITION BY c.unit_kerja_id ORDER BY c.id) as unit_kerja_index
            FROM
                customers c
            INNER JOIN  -- Or LEFT JOIN if you want customers even if they don't have a unit_kerja
                unit_kerjas u ON c.unit_kerja_id = u.id;  -- The join condition
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS ordered_data;");
    }
};
