<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalculatorFeedback;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'calculator_id' => 'required',
            'visitor_id' => 'required',
            'rating' => 'required',
            'comment' => 'required',
        ]);
        $calculator_id = $request->calculator_id;
        $visitor_id = $request->visitor_id;
        $feedback = CalculatorFeedback::where('calculator_id',$calculator_id)->where('visitor_id',$visitor_id)->first();
        if(!$feedback)
        {
            $feedback = new CalculatorFeedback();
            $feedback->calculator_id = $calculator_id;
            $feedback->visitor_id = $visitor_id;
        }
        $feedback->comment = $request->comment;
        $feedback->rating = $request->rating;
        $feedback->save();
        return response()->json(['success' => true, 'data' => $feedback]);
    }

    public function fetch(Request $request)
    {
        $request->validate([
            'calculator_id' => 'required',
            'visitor_id' => 'required'
        ]);
        $calculator_id = $request->calculator_id;
        $visitor_id = $request->visitor_id;
        $feedback = CalculatorFeedback::where('calculator_id',$calculator_id)->where('visitor_id',$visitor_id)->first();
        return response()->json(['success' => true, 'data' => $feedback]);
    }

}
