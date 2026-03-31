<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'ip', 
        'user_agent', 
        'visitor_uuid',
        'city',
        'country'
    ];

    public function activity()
    {
        return $this->hasMany(TrackVisitor::class,'visitor_id','id');
    }
    public function pageviews()
    {
        return $this->hasMany(TrackVisitor::class,'visitor_id','id')->where('event_type','page_view');
    }
    public function last_activity()
    {
        return $this->hasOne(TrackVisitor::class,'visitor_id','id')->latestOfMany();
    }
    public function calculations()
    {
        return $this->hasMany(Calculation::class,'visitor_id','id');
    }
}
