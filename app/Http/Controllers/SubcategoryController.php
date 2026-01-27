<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\Subcategory;
use App\Models\Category;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('status',1)->get();
        return view('subcategories.index',compact('categories'));
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
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required'
        ]);

        $category = new Subcategory();
        $category->title = $request->title;
        $category->description = $request->description ?? null;
        $category->content = $request->content ?? null;
        $category->category_id = $request->category_id;
        $category->save();

        return response()->json(['success' => true, 'data' => $category]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Subcategory::find($id);
        return response()->json(['success' => true, 'data' => $category]);
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
        ]);

        $category = Subcategory::find($id);
        $category->title = $request->title;
        $category->description = $request->description ?? null;
        $category->content = $request->content ?? null;
        $category->save();
        return response()->json(['success' => true, 'data' => $category]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Subcategory::find($id);
        $category->delete();
        return response()->json(['success' => true, 'data' => $category]);
    }

    public function listAll(Request $request)
    {
        $query = Subcategory::query();
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
                return view('subcategories.partials._action',['query' => $query]);
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }
}
