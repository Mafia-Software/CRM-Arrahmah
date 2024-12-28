<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesanMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'wa_server_id',
        'no_wa',
        'pesan',
    ];
}
