<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesanKeluar extends Model
{
    //

    use SoftDeletes;
    use HasFactory;

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