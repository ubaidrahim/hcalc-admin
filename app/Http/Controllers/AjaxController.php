<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use App\Traits\ImageStore;

class AjaxController extends Controller
{
    use ImageStore;
    public function statusEnableDisable(Request $request)
    {


        try {
            $id = $request->id;
            $table = $request->table;
            $status = $request->status;
            $result = DB::table($table)->where('id', $id)->update(['status' => $status]);

            if ($result) {
                return response()->json(['success' => 'Status has been changed']);
            } else {
                return response()->json(['error' => 'Something went wrong' . '!'], 400);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function ckeditor_img(Request $request){
        $image = '';
        $url = '';
        $fileName = '';
        if($request->hasFile('upload')){
            $image = $this->saveImage($request->upload);
            $url = url($image);
            $fileName = basename($image);
        }
        return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
    }
}
