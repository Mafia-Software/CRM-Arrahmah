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
        Schema::create('pesan_keluars', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string("customer_id")->constrained('customers');
            $table->string("history_id")->constrained('histories');
            $table->string("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesan_keluars');
    }
};
