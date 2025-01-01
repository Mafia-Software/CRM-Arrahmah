<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitKerja extends Model
{
    use SoftDeletes;
    use HasFactory;
    //
    protected $fillable = [
        'id',
        'name',
        'description',
    ];
}