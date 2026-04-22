<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculatorFeedback extends Model
{
    public function calculator()
    {
        return $this->belongsTo('calculator_id','id');
    }
}
