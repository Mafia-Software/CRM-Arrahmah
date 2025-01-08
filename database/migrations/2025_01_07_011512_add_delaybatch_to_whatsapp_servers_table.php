<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('whatsapp_servers', function (Blueprint $table) {
            //
            $table->integer('delaybatch')->default(5);
            $table->integer('jumlahbatch')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whatsapp_servers', function (Blueprint $table) {
            //
        });
    }
};
