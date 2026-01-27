<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AjaxController extends Controller
{
    public function displayIcons($set = 'mdi')
    {
        $icons = Cache::remember("iconify_{$set}", now()->addDays(7), function () use ($set) {
            $response = Http::get("https://api.iconify.design/collection");
            return $response->json();
        });
        if(!$icons){
            return response()->json(['status' => false, 'message' => 'Unable to fetch icons']);
        }
        // return response()->json(['status' => true, 'icons' => $icons, 'set' => $set]);
        return response()->json(['status' => true, 'icons' => $icons]);
    }
}
