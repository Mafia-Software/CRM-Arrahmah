<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhatsappServer extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nama',
        'no_wa',
        'api_key',
        'service_status',
        'delay',
        'delaybatch',
        'jumlahbatch',
    ];
}
