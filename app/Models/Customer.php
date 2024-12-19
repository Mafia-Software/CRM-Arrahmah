<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $fillable = [
        'id',
        'nama',
        'alamat',
        'no_wa',
        'unit_kerja_id',
        'response',

    ];

    public function unitKerja()
    {

        return $this->belongsTo(UnitKerja::class, 'id');
    }

    public function response()
    {
        return $this->belongsTo(Response::class, 'id');
    }
}
