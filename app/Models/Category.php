<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class,'category_id','id');
    }

    public function calculators()
    {
        return $this->hasMany(Calculator::class,'category_id','id');
    }
}
