<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappServer extends Model
{
    protected $fillable = [
        'nama',
        'no_wa',
        'api_key',
        'service_status',
        'is_active',
        'delay',
    ];

    public function getDelayAttribute($value)
    {
        return $value . ' detik';
    }
}
