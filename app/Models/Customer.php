<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $fillable = [
        'id',
        'user_id',
        'nama',
        'alamat',
        'no_wa',
        'unit_kerja_id',
        'response_id',
        'user_id',

    ];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function response()
    {
        return $this->belongsTo(Response::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
