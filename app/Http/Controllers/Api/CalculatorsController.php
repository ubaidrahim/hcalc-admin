<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Calculator;
use App\Models\Calculation;
use Illuminate\Support\Facades\Crypt; 
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
        $calculator = Calculator::where('slug',$slug)->where('status',1)->first();
        if($calculator)
        {
            $avgRating = $calculator->averageRating();
            $reviews = $calculator->feedbacks()->where('status',1)->count();
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
                'avgRating' => $avgRating,
                'reviews' => $reviews,
                'related_calcs' => $related_calcs_data,
            ];
            return response()->json(['success' => true, 'data' => $data]);
        }
        return response()->json(['success' => false, 'data' => []]);
    }

    public function recordCalculation(Request $request)
    {
        $data = $request->validate([
            'inputs' => ['required','array'],
            'result' => ['required','array'],
            'calculator_id' => ['required','exists:calculators,id'],
            'visitor_id' => ['nullable']
        ]);

        $calculation = Calculation::create($data);
        if($calculation)
        {
            $uuid = $calculation->public_id;
            return response()->json(['success' => true, 'data' => ['id' => $calculation->id, 'uuid' => $uuid] ]);
        }
        return response()->json(['success' => false]);
    }

    public function fetchCalculation($uuid)
    {
        $calculation = Calculation::where('public_id',$uuid)->first();
        if($calculation)
        {
            $data = [
                'id' => $calculation->id,
                'uuid' => $calculation->public_id,
                'inputs' => $calculation->inputs,
                'result' => $calculation->result
            ];
            return response()->json(['success' => true, 'data' => $data]);
        }
        return response()->json(['success' => false]);
    }

    public function search(Request $request)
    {
        $search = $request->search ?? '';
        $searchParam = '%'.$search.'%';
        $calculators = Calculator::where('title','like',$searchParam)->where('status',1)->get();
        $result = $calculators->map(function($calculator) {
            return [
                        'title' => $calculator->title,
                        'description' => $calculator->description ?? '',
                        'slug' => $calculator->slug && $calculator->slug != '' ? $calculator->slug : 'not-found',
                        'tags' => $calculator->meta_keywords && $calculator->meta_keywords != '' ? explode(',', $calculator->meta_keywords) : []    
                    ];
        });
        return response()->json(['success' => true, 'data' => $result]);
    }
    public function famous(Request $request)
    {
        $calculators = Calculator::where('status',1)
        ->withCount('calculations')
        ->orderBy('calculations_count','desc')
        ->take(5)
        ->get();
        $result = $calculators->map(function($calculator) {
            return [
                        'title' => $calculator->title,
                        'description' => $calculator->description ?? '',
                        'slug' => $calculator->slug && $calculator->slug != '' ? $calculator->slug : 'not-found',
                        'tags' => $calculator->meta_keywords && $calculator->meta_keywords != '' ? explode(',', $calculator->meta_keywords) : [],
                        'count' => $calculator->calculations_count    
                    ];
        });
        return response()->json(['success' => true, 'data' => $result]);
    }
    public function recent(Request $request)
    {
        $calculators = Calculator::where('status',1)
        ->latest()
        ->take(5)
        ->get();
        $result = $calculators->map(function($calculator) {
            return [
                        'title' => $calculator->title,
                        'description' => $calculator->description ?? '',
                        'slug' => $calculator->slug && $calculator->slug != '' ? $calculator->slug : 'not-found',
                        'tags' => $calculator->meta_keywords && $calculator->meta_keywords != '' ? explode(',', $calculator->meta_keywords) : []    
                    ];
        });
        return response()->json(['success' => true, 'data' => $result]);
    }
    
}
