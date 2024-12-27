<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //
    protected $fillable = [
        'id',
        'user_id',
        'whatsapp_server_id',
    ];
}
