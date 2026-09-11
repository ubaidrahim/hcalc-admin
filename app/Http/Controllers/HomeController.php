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
                $file = $request->file($key);
            //   $content->value = $this->saveImage($value); 
            dd([
    'php_user' => posix_getpwuid(posix_geteuid())['name'] ?? posix_geteuid(),
    'file_error' => $file->getError(),
    'is_valid' => $file->isValid(),
    'is_uploaded_file' => is_uploaded_file($file->getPathname()),
    'tmp_file' => $file->getPathname(),
    'tmp_exists' => file_exists($file->getPathname()),
    'uploads_path' => public_path('uploads'),
    'uploads_exists' => is_dir(public_path('uploads')),
    'uploads_writable' => is_writable(public_path('uploads')),
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
