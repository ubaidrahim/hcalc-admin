<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculator extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class,'subcategory_id','id');
    }

    public function calculations()
    {
        return $this->hasMany(Calculation::class,'calculator_id','id');
    }
    public function feedbacks()
    {
        return $this->hasMany(CalculatorFeedback::class,'calculator_id','id');
    }
    public function averageRating()
    {
        $sumrating = $this->feedbacks()->where('status',1)->sum('rating');
        $total = $this->feedbacks()->where('status',1)->count();
        if($total > 0)
        {
            $avg = $sumrating / $total;
            return floor($avg);
        }
        return 0;
    }
}
