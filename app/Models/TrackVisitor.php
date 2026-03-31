<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackVisitor extends Model
{
    protected $fillable = [
        'visitor_id','event_type','url','referrer','user_agent','ip','meta'
    ];

    protected $casts = [
        'meta' => 'array'
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class,'visitor_id','id');
    }
}
