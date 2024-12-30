<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesanKeluar extends Model
{
    //

    protected $fillable = [
        "id",
        "customer_id",
        "history_id",
        "status"
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function history()
    {
        return $this->belongsTo(History::class);
    }
}
