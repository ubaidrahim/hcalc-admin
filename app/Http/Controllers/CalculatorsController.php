<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\Subcategory;
use App\Models\Category;
use App\Models\Calculator;
use App\Traits\ImageStore;

class CalculatorsController extends Controller
{
    use ImageStore;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('status',1)->get();
        $subcategories = Subcategory::where('status',1)->get();
        return view('calculators.index',compact('categories','subcategories'));
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
            'slug' => 'required|string|max:100|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|unique:calculators,slug',
        ]);

        $calculator = new Calculator();
        $calculator->title = $request->title;
        $calculator->slug = $request->slug ?? null;
        $calculator->meta_title = $request->meta_title ?? null;
        $calculator->meta_description = $request->meta_description ?? null;
        $calculator->meta_keywords = $request->meta_keywords ?? null;
        $calculator->description = $request->description ?? null;
        $calculator->related_calcs = $request->related_calcs && is_array($request->related_calcs) ? json_encode($request->related_calcs) : json_encode(array());
        $calculator->content = $request->content ?? null;
        $calculator->category_id = $request->category_id;
        $calculator->subcategory_id = $request->subcategory_id ?? 0;
        if($request->image)
        {
            $calculator->image = $this->saveImage($request->image);
        }
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
        $calculators = Calculator::where('id','<>',$id)->where('status',1)->get();
        $calc = Calculator::find($id);
        $related = $calc && $calc->related_calcs && is_string($calc->related_calcs) ? json_decode($calc->related_calcs) : [];
        return response()->json(['success' => true, 'data' => $calculators, 'related' => $related]);
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
            'slug' => 'required|string|max:100|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|unique:calculators,slug,'.$id,
        ]);

        $calculator = Calculator::find($id);
        $calculator->title = $request->title;
        $calculator->slug = $request->slug ?? null;
        $calculator->meta_title = $request->meta_title ?? null;
        $calculator->meta_description = $request->meta_description ?? null;
        $calculator->meta_keywords = $request->meta_keywords ?? null;
        $calculator->description = $request->description ?? null;
        $calculator->content = $request->content ?? null;
        $calculator->category_id = $request->category_id;
        $calculator->subcategory_id = $request->subcategory_id ?? 0;
        if($request->image)
        {
            $calculator->image = $this->saveImage($request->image);
        }
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
    
    public function listAll(Request $request)
    {
        $query = Calculator::query();
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('title', function($query){
                return $query->title;
            })
            ->editColumn('description', function($query){
                return $query->description;
            })
            ->editColumn('category', function($query){
                return $query->category->title ?? '';
            })
            ->editColumn('subcategory', function($query){
                return $query->subcategory->title ?? '';
            })
            ->editColumn('average', function($query){
                $avg = $query->averageRating();
                $total = $query->feedbacks->count();
                return '<span class="text-nowrap"><i class="ri ri-star-fill text-warning"></i> '.number_format($avg,1).'/5.0</span><br><strong>Total:</strong> '.$total;
            })
            ->editColumn('status', function($query){
                $checked = $query->status == 1 ? "checked" : "";
                $view = '<label class="form-check form-switch" for="active_checkbox' . $query->id . '">
                                                    <input type="checkbox" class="form-check-input status_enable_disable" role="switch"
                                                           id="active_checkbox' . $query->id . '" value="' . $query->id . '"
                                                             ' . $checked . '><i class="slider round"></i></label>';
                return $view;
            })
            ->editColumn('action', function($query){
                return view('calculators.partials._action',['query' => $query]);
            })
            ->rawColumns(['action','status','average'])
            ->make(true);
    }
}
