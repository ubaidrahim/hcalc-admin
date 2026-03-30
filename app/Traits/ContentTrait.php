<?php

namespace App\Traits;

use App\Models\HomeContent;
use App\Models\FooterContent;

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
    public function getFooterContent($key)
    {
        $content = FooterContent::where('key',$key)->where('status',1)->first();
        if($content)
        {
            return $content->value;
        }
        return '';
    }
}
