<?php

namespace App\Traits;

use App\Models\HomeContent;

trait ContentTrait
{
    public function getHomeContent($key)
    {
        $content = HomeContent::where('key',$key)->where('status',1)->first();
        if($content)
        {
            return $content->value;
        }
        return '';
    }
}
