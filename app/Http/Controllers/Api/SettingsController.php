<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebsiteSetting;

class SettingsController extends Controller
{
    public function show($key)
    {
        $setting = WebsiteSetting::where('key',$key)->where('status',1)->first();
        $value = '';
        if($setting && $setting->value != '')
        {
            $value = $setting->is_resource == 1 ? asset($setting->value) : $setting->value;
        }
        return response()->json(['success' => true, 'data' => $value]);
        
    }
}
