<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappServer extends Model
{
    protected $fillable = [
        'nama',
        'no_wa',
        'is_active',
        'instance_id',
    ];
}
