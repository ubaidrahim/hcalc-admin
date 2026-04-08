<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteScript;

class SiteScriptsController extends Controller
{
    //
    public function index()
    {
        $scripts = SiteScript::where('status',1)->get();
        $scriptsArray = [];
        foreach($scripts as $script)
        {
            $scriptsArray[] = [
                'id' => $script->id,
                'name' => $script->name,
                'type' => $script->type,
                'placement' => $script->placement,
                'config' => json_decode($script->config_json) ?? null
            ];
        }
        return response()->json(['success' => true, 'data' => $scriptsArray]);
    }
}
