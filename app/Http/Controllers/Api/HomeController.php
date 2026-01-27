<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Traits\ContentTrait;

class HomeController extends Controller
{
    use ContentTrait;
    public function categories()
    {
        $categories = Category::where('status',1)->latest()->limit(9)->get();
        $categories = $categories->map(function($cat){
            $catArray = [
                'title' => $cat->title,
                'description' => $cat->description ?? ''
            ];
            return $catArray;
        });
        return response()->json(['status' => true, 'data' => $categories]);
    }

    public function meta()
    {
        $data = [
            'title' => $this->getHomeContent('title'),
            'description' => $this->getHomeContent('meta_description')
        ];
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function content()
    {
        $data = [
            'hero_title' => $this->getHomeContent('hero_title'),
            'hero_description' => $this->getHomeContent('hero_description'),
            'hero_bg' => asset($this->getHomeContent('hero_bg'))
        ];
        return response()->json(['status' => true, 'data' => $data]);
    }
}
