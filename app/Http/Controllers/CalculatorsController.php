<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calculator;

class CalculatorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('calculators.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
        ]);

        $calculator = new Calculator();
        $calculator->title = $request->title;
        $calculator->description = $request->description ?? null;
        $calculator->content = $request->content ?? null;
        $calculator->category_id = $request->category_id;
        $calculator->subcategory_id = $request->subcategory_id;
        $calculator->save();

        return response()->json(['success' => true, 'data' => $calculator]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $calculator = Calculator::find($id);
        return response()->json(['success' => true, 'data' => $calculator]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
        ]);

        $calculator = Calculator::find($id);
        $calculator->title = $request->title;
        $calculator->description = $request->description ?? null;
        $calculator->content = $request->content ?? null;
        $calculator->category_id = $request->category_id;
        $calculator->subcategory_id = $request->subcategory_id;
        $calculator->save();
        return response()->json(['success' => true, 'data' => $calculator]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $calculator = Calculator::find($id);
        $calculator->delete();
        return response()->json(['success' => true, 'data' => $calculator]);
    }
}
