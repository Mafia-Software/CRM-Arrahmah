<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends Model
{
    use SoftDeletes;
    use HasFactory;
    //
    protected $fillable = [
        'id',
        'user_id',
        'content_planner_id',
        'whatsapp_server_id',
        'batch_id',
        'eta'
    ];

    public function contentPlanner()
    {
        return $this->belongsTo(ContentPlanner::class);
    }

    public function whatsappServer()
    {
        return $this->belongsTo(WhatsappServer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
