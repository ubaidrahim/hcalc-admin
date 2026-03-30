<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Traits\ContentTrait;

class FooterController extends Controller
{
    use ContentTrait;

    public function content()
    {
        $data = [
            'colOneTitle' => $this->getFooterContent('colOneTitle'),
            'colOneDesc' => $this->getFooterContent('colOneDesc'),
            'colOneLinkText' => $this->getFooterContent('colOneLinkText'),
            'colOneLinkUrl' => $this->getFooterContent('colOneLinkUrl'),
            'colTwoTitle' => $this->getFooterContent('colTwoTitle'),
            'colTwoDesc' => $this->getFooterContent('colTwoDesc'),
            'colTwoLinkText' => $this->getFooterContent('colTwoLinkText'),
            'colTwoLinkUrl' => $this->getFooterContent('colTwoLinkUrl'),
            'colThreeTitle' => $this->getFooterContent('colThreeTitle'),
            'colThreeDesc' => $this->getFooterContent('colThreeDesc'),
            'colThreeLinkText' => $this->getFooterContent('colThreeLinkText'),
            'colThreeLinkUrl' => $this->getFooterContent('colThreeLinkUrl'),
            'brief' => $this->getFooterContent('brief'),
            'footerNote' => $this->getFooterContent('footerNote'),
        ];
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function categories()
    {
        $categories = Category::where('status',1)->latest()->limit(10)->get();
        $categories = $categories->map(function($cat){
            $catArray = [
                'id' => $cat->id,
                'title' => $cat->title,
                'icon' => $cat->icon ?? '',
                'description' => $cat->description ?? '',
                'slug' => $cat->slug && $cat->slug != '' ? $cat->slug : '#' 
            ];
            return $catArray;
        });
        return response()->json(['success' => true, 'data' => $categories]);
    }
}
