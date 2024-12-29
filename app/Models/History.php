<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //
    protected $fillable = [
        'id',
        'user_id',
        'content_planner_id',
        'batch_id',
        'whatsapp_server_id',
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
