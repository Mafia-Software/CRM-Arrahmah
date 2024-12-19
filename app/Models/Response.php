<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    //
    protected $fillable = [
        'id',
        'name',
        'code'
    ];

    public function customer()
    {
        return $this->hasMany(Customer::class, 'id');
    }
}