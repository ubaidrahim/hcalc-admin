<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'slug' => 'required|string|max:30|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|unique:categories,slug',
        ]);

        $category = new Category();
        $category->title = $request->title;
        $category->description = $request->description ?? null;
        $category->content = $request->content ?? null;
        $category->slug = $request->slug ?? null;
        $category->meta_title = $request->meta_title ?? null;
        $category->meta_description = $request->meta_description ?? null;
        $category->meta_keywords = $request->meta_keywords ?? null;
        $category->save();

        return response()->json(['success' => true, 'data' => $category]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
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
            'content' => 'required',
            'slug' => 'required|string|max:30|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|unique:categories,slug,'.$id,
        ]);

        $category = Category::find($id);
        $category->title = $request->title;
        $category->description = $request->description ?? null;
        $category->content = $request->content ?? null;
        $category->slug = $request->slug ?? null;
        $category->meta_title = $request->meta_title ?? null;
        $category->meta_description = $request->meta_description ?? null;
        $category->meta_keywords = $request->meta_keywords ?? null;
        $category->save();
        return response()->json(['success' => true, 'data' => $category]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json(['success' => true, 'data' => $category]);
    }

    public function listAll(Request $request)
    {
        $query = Category::query();
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('title', function($query){
                return $query->title;
            })
            ->editColumn('description', function($query){
                return $query->description;
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
                return view('categories.partials._action',['query' => $query]);
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }
}
