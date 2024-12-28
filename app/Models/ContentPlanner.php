<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentPlanner extends Model
{
    //
    protected $fillable = [
        "id",
        "pesan",
        'tanggal',
        'media',
    ];

    public function getCleanTextAttribute()
    {
        return strip_tags($this->pesan);
    }
}
