<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Calculator;

class CalculatorsController extends Controller
{

    public function index()
    {
        $calculators = Calculator::where('status',1)->get();
        return response()->json(['success' => true, 'data' => $calculators]);
    }

    public function meta($slug)
    {
        $calculator = Calculator::where('slug',$slug)->first();
        $data = [
            'title' => '',
            'description' => ''
        ];
        if($calculator)
        {
            $data['title'] = $calculator->meta_title && $calculator->meta_title != '' ? $calculator->meta_title : $calculator->title;
            $data['description'] = $calculator->meta_description && $calculator->meta_description != '' ? $calculator->meta_description : '';
            return response()->json(['success' => true, 'data' => $data]);
        }
        return response()->json(['success' => false, 'data' => $data]);
    }

    public function show($slug)
    {
        $calculator = Calculator::where('slug',$slug)->first();
        if($calculator)
        {
            $related_calcs = $calculator->related_calcs && $calculator->related_calcs != '' ? json_decode($calculator->related_calcs) : [];
            $related_calcs_data = [];
            foreach($related_calcs as $related_calc_id)
            {
                $related_cal = Calculator::where('id',$related_calc_id)->first();
                if($related_cal)
                {
                    $related_calcs_data[] = [
                        'title' => $related_cal->title,
                        'description' => $related_cal->description ?? '',
                        'slug' => $related_cal->slug && $related_cal->slug != '' ? $related_cal->slug : 'not-found',
                    ];
                }
            }
            $data = [
                'id' => $calculator->id,
                'title' => $calculator->title,
                'description' => $calculator->description ?? '',
                'slug' => $calculator->slug && $calculator->slug != '' ? $calculator->slug : 'not-found',
                'component' => $calculator->component && $calculator->component != '' ? $calculator->component : 'notFound',
                'content' => $calculator->content ?? '',
                'related_calcs' => $related_calcs_data,
            ];
            return response()->json(['success' => true, 'data' => $data]);
        }
        return response()->json(['success' => false, 'data' => []]);
    }
}
