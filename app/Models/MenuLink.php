<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuLink extends Model
{
    const TYPE_CUSTOM_LINK = 1;
    const TYPE_CATEGORY = 2;
    const TYPE_CALCULATOR = 3;
    const TYPE_CATEGORY_CALCULATORS = 4;
    const MENU_TYPES = [
        1 => 'Custom Link',
        2 => 'Category',
        3 => 'Calculator',
        4 => 'Auto Category Calculators'
    ];

    public function children()
    {
        return $this->hasMany(self::class,'parent_id');
    }
    
    public function parent()
    {
        return $this->belongsTo(self::class,'parent_id');
    }
}
