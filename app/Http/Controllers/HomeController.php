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
            if($request->hasFile($key))
            {
            //   $content->value = $this->saveImage($value); 
            $file = $request->file($key);

$destination = public_path('uploads/test');

if (!is_dir($destination)) {
    mkdir($destination, 0777, true);
}

$filename = 'test_' . time() . '.' . $file->extension();

$moved = $file->move($destination, $filename);

dd([
    'destination' => $destination,
    'filename' => $filename,
    'moved_path' => $moved->getPathname(),
    'exists' => file_exists($destination . '/' . $filename),
]);
            }
            else{
                $content->value = $value ?? '';
            }
            $content->save();
        }
        return response()->json(['success' => true, 'data' => $content, 'goto' => route('content.home.index')]);
    }
}
