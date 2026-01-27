<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeContent;
use App\Traits\ImageStore;

class HomeController extends Controller
{
    use ImageStore;
    public function index()
    {
        return view('home.index');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            $content = HomeContent::where('key',$key)->first();
            if(!$content)
            {
                $content = new HomeContent();
                $content->key = $key;
            }
            $content->value = $request->hasFile($key) ? $this->saveImage($value) : $value;
            $content->save();
        }
        return response()->json(['success' => true, 'data' => $content, 'goto' => route('content.home.index')]);
    }
}
