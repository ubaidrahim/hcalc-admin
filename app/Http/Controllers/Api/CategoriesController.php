<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $list = Category::where('status',1)->where('status',1)->get();
        $categories = $list->map(function($cat){
            $catArray = [
                'title' => $cat->title,
                'description' => $cat->description ?? '',
                'icon' => $cat->icon ?? '',
                'slug' => $cat->slug && $cat->slug != '' ? $cat->slug : 'not-found',
                'tags' => $cat->meta_keywords && $cat->meta_keywords != '' ? explode(',', $cat->meta_keywords) : []
            ];
            return $catArray;
        });
        return response()->json(['success' => true, 'data' => $categories]);
    }

    public function meta($slug)
    {
        $fetch = Category::where('slug',$slug)->where('status',1)->first();
        $data = [
            'title' => '',
            'description' => ''
        ];
        if($fetch)
        {
            $data['title'] = $fetch->meta_title && $fetch->meta_title != '' ? $fetch->meta_title : $fetch->title;
            $data['description'] = $fetch->meta_description && $fetch->meta_description != '' ? $fetch->meta_description : '';
            return response()->json(['success' => true, 'data' => $data]);
        }
        return response()->json(['success' => false, 'data' => $data]);
    }
    public function show($slug)
    {
        $fetch = Category::where('slug',$slug)->where('status',1)->with('calculators')->first();
        if($fetch)
        {
            $data = [
                'title' => $fetch->title,
                'description' => $fetch->description ?? '',
                'slug' => $fetch->slug && $fetch->slug != '' ? $fetch->slug : 'not-found',
                'calculators' => $fetch->calculators->where('status',1)->map(function($calculator){
                    return [
                        'title' => $calculator->title,
                        'description' => $calculator->description ?? '',
                        'slug' => $calculator->slug && $calculator->slug != '' ? $calculator->slug : 'not-found',
                        'tags' => $calculator->meta_keywords && $calculator->meta_keywords != '' ? explode(',', $calculator->meta_keywords) : []    
                    ];
                })
            ];
            return response()->json(['success' => true, 'data' => $data]);
        }
        return response()->json(['success' => false, 'data' => []]);
    }
}
