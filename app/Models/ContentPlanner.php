<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentPlanner extends Model
{
    //
    use SoftDeletes;
    use HasFactory;
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