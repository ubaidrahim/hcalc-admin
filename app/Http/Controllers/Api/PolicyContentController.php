<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PolicyContent;
use Carbon\Carbon;

class PolicyContentController extends Controller
{
    public function index($type)
    {
        $data = [
            'title' => '',
            'content' => '',
            'updated_at' => null
        ];
        foreach ($data as $key => $value) {
            $policy = PolicyContent::where('key',$key)
            ->where('type',$type)
            ->where('status',1)->first();
            if($policy)
            {
                $data[$key] = $policy->value;
                $data['updated_at'] = Carbon::parse($policy->updated_at)->format(formatted_date());
            }

        }
        return response()->json(['success' => true, 'data' => $data]);
    }
}
