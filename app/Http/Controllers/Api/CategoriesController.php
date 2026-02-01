<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $list = Category::where('status',1)->get();
        return response()->json(['success' => true, 'data' => $list]);
    }

    public function meta($slug)
    {
        $fetch = Category::where('slug',$slug)->first();
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
        $fetch = Category::where('slug',$slug)->first();
    }
}
