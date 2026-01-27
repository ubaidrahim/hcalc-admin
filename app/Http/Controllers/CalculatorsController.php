<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\Subcategory;
use App\Models\Category;
use App\Models\Calculator;

class CalculatorsController extends Controller
{
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
            ->editColumn('status', function($query){
                switch ($query->status) {
                    case 0:
                        return '<span class="badge badge-warning">Inactive</span>';
                        break;
                    case 1:
                        return '<span class="badge badge-success">Active</span>'; 
                        break;
                    
                    default:
                        # code...
                        break;
                }
            })
            ->editColumn('action', function($query){
                return view('calculators.partials._action',['query' => $query]);
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }
}
