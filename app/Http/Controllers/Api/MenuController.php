<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuLink;
use App\Models\Category;
use App\Models\Calculator;

class MenuController extends Controller
{
    public function show($menu)
    {
        $data = [];
        $links = MenuLink::where('menu_location',$menu)
            ->with('children')
            ->where('parent_id',0)
            ->orderBy('order','asc')
            ->get();
        foreach($links as $item){
        // $data = $links->map(function($item){
            $data[] = $this->makeMenu($item);
        }
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function makeMenu($item)
    {
        $arr = null;
        if($item->type == \App\Models\MenuLink::TYPE_CUSTOM_LINK){
                $arr = [
                    'title' => $item->title,
                    'url' => $item->url,
                    'new_window' => $item->open_in_new_tab,
                    'css_class' => $item->css_class,
                    'icon' => null
                ];
                if(count($item->children) > 0)
                {
                    foreach ($item->children as $childitem){
                    // $children = $item->children->map(function($childitem){
                        $children = $this->makeMenu($childitem);
                    }
                    $arr['children'] = $children;
                }
            }
            if($item->type == \App\Models\MenuLink::TYPE_CATEGORY){
                $category = Category::where('id',$item->category_id)->where('status',1)->first();
                if($category)
                {
                    $arr = [
                        'title' => $category->title,
                        'url' => 'categories/'.$category->slug,
                        'new_window' => $item->open_in_new_tab,
                        'css_class' => $item->css_class,
                        'icon' => $category->icon
                    ];
                }
            }
            if($item->type == \App\Models\MenuLink::TYPE_CALCULATOR){
                $calculator = Calculator::where('id',$item->calculator_id)->where('status',1)->first();
                if($calculator)
                {
                    $arr = [
                        'title' => $calculator->title,
                        'url' => 'categories/'.$calculator->slug,
                        'new_window' => $item->open_in_new_tab,
                        'css_class' => $item->css_class,
                        'icon' => $calculator->icon
                    ];
                }
            }
            if($item->type == \App\Models\MenuLink::TYPE_CATEGORY_CALCULATORS){
                $categories = Category::where('status',1)->with('calculators')->get();
                foreach ($categories as $catitem) {
                // $arr = $categories->map(function($catitem) use ($item){
                    $catArr = [
                        'title' => $catitem->title,
                        'url' => 'categories/'.$catitem->slug,
                        'new_window' => $item->open_in_new_tab,
                        'css_class' => $item->css_class,
                        'icon' => $catitem->icon
                    ];
                    if(count($catitem->calculators) > 0)
                    {
                        foreach ($catitem->calculators as $calitem) {
                        // $calculators = $catitem->calculators->map(function($calitem)  use ($item){
                            $calArr[] = [
                                'title' => $calitem->title,
                                'url' => '/'.$calitem->slug,
                                'new_window' => $item->open_in_new_tab,
                                'css_class' => $item->css_class,
                                'icon' => $calitem->icon

                            ];
                        }
                        $catArr['children'] = $calArr;
                    }
                    $arr[] = $catArr;
                }
            }
            return $arr;
    }
}
