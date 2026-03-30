<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FooterContent;
use App\Traits\ImageStore;

class FooterController extends Controller
{
    use ImageStore;
    public function index()
    {
        return view('footer.index');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            $content = FooterContent::where('key',$key)->first();
            if(!$content)
            {
                $content = new FooterContent();
                $content->key = $key;
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
        return response()->json(['success' => true, 'data' => $content, 'goto' => route('content.footer.index')]);
    }
}
