<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PolicyContent;
use App\Traits\ImageStore;

class PolicyController extends Controller
{
    use ImageStore;
    public function index($type)
    {
        if(!in_array($type,['privacy_policy','terms']))
        {
            abort(404);
        }
        return view('policy.index',compact('type'));
    }

    public function store(Request $request,$type)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            $content = PolicyContent::where('key',$key)->where('type',$type)->first();
            if(!$content)
            {
                $content = new PolicyContent();
                $content->key = $key;
                $content->type = $type;
            }
            if($request->hasFile($key))
            {
                $content->value = $this->saveImage($value);
            }
            else
            {
                $content->value = $value ?? '';
            }
            $content->save();
        }
        return response()->json(['success' => true, 'data' => $content, 'goto' => route('content.policy.index',['type' => $type])]);
    }
}
