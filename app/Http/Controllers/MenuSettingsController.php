<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuLink;
use Carbon\Carbon;

class MenuSettingsController extends Controller
{
    public function index($menu = null)
    {
        $menulinks = null;
        if($menu)
        {
            $menulinks = MenuLink::where('menu_location',$menu)
            ->where('parent_id',0)
            ->orderBy('order','asc')
            ->get();
        }
        return view('menu.index',compact('menu','menulinks'));
    }

    public function addItem(Request $request)
    {
        $type = $request->type ?? 0;
        $count = $request->count ?? 0;
        $parent = $request->parent ?? 0;
        $count = $count + 1;
        $menuitem = null;
        $itemview = view('menu.item',compact('type','count','parent','menuitem'))->render();
        return response()->json(['success' => true, 'data' => $itemview]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu' => 'required'
        ]);
        $items = $request->item ?? array();
        foreach ($items as $key => $item) {
            $remove = $item['remove'] ?? 0;
            if($remove == 0)
            {
                $type = $item['type'] ?? 0;
                $parent = $item['parent_id'];
                $parent = $items[$parent]['id'] ?? 0;
                $url = null;
                $category_id = null;
                $calculator_id = null;
                if($type == \App\Models\MenuLink::TYPE_CUSTOM_LINK){
                    $url = $item['url'] ?? '#';
                }
                if($type == \App\Models\MenuLink::TYPE_CATEGORY){
                    $category_id = $item['category_id'] ?? null;
                }
                if($type == \App\Models\MenuLink::TYPE_CALCULATOR){
                    $calculator_id = $item['calculator_id'] ?? null;
                }
                $link = MenuLink::find($item['id']);
                if(!$link)
                {
                    $link = new MenuLink();
                    $link->menu_location = $request->menu;
                    $link->type = $item['type'];
                    $link->parent_id = $parent;
                }
                $link->title = $item['title'];
                $link->url = $url;
                $link->category_id = $category_id;
                $link->calculator_id = $calculator_id;
                $link->open_in_new_tab = 0;
                $link->css_class = null;
                $link->order = $item['order'];
                $link->save();
                if($item['id'] == 0)
                {
                    $items[$key]['id'] = $link->id;
                }
            }
            else{
                if($item['id'] != 0)
                    {
                        $delete = MenuLink::where('id',$item['id'])->delete();
                    }
            }

        }
        return response()->json(['success' => true, 'goto' => url('settings/menu/'.$request->menu)]);
    }
}
