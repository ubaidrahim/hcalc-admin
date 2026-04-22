<?php

namespace App\Traits;

use App\Models\HomeContent;
use App\Models\FooterContent;
use App\Models\PolicyContent;

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
    public function getPolicyContent($key,$type)
    {
        $content = PolicyContent::where('key',$key)
        ->where('type',$type)
        ->where('status',1)->first();
        if($content)
        {
            return $content->value;
        }
        return '';
    }
}
