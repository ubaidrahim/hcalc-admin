<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function calculators()
    {
        return $this->hasMany(Calculator::class,'subcategory_id','id');
    }
}
