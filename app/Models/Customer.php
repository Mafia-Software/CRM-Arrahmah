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
        'unit_kerja',
        'response',

    ];

    public function unitKerja () {
        
        return $this->belongsTo(UnitKerja::class);
    }

    public function response() {
        return $this->belongsTo(Response::class);
    }
}
