<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Calculation extends Model
{
    protected $fillable = [
        'inputs',
        'result',
        'calculator_id',
        'visitor_id'
    ];

    protected $casts = [
        'inputs' => 'array',
        'result' => 'array'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->public_id)) {
            $model->public_id = (string) Str::uuid();
        }
        });
    }
}
