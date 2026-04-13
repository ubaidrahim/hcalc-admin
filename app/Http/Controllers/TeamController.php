<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\ImageStore;
use Carbon\Carbon;
use App\Models\OurTeam;

class TeamController extends Controller
{
    use ImageStore;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('team.index');
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
            'name' => 'required',
            'designation' => 'required',
            'brief' => 'required',
        ]);
        $team = new OurTeam();
        $team->name = $request->name;
        $team->designation = $request->designation;
        $team->brief = $request->brief;
        if($request->image)
        {
            $team->image = $this->saveImage($request->image);
        }
        $team->facebook = $request->facebook ?? null;
        $team->linkedin = $request->linkedin ?? null;
        $team->github = $request->github ?? null;
        $team->whatsapp = $request->whatsapp ?? null;
        $team->instagram = $request->instagram ?? null;
        $team->behance = $request->behance ?? null;
        $team->youtube = $request->youtube ?? null;
        $team->upwork = $request->upwork ?? null;
        $team->fiverr = $request->fiverr ?? null;
        $team->tiktok = $request->tiktok ?? null;
        $team->portfolio = $request->portfolio ?? null;
        $team->save();
        return response()->json(['success' => true, 'data' => $team]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $team = OurTeam::find($id);
        if($team)
        {
            return response()->json(['success' => true, 'data' => $team]);
        }
        return response()->json(['success' => false, 'message' => 'Team member not found']);
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
            'name' => 'required',
            'designation' => 'required',
            'brief' => 'required',
        ]);
        $team = OurTeam::find($id);
        $team->name = $request->name;
        $team->designation = $request->designation;
        $team->brief = $request->brief;
        if($request->image)
        {
            $team->image = $this->saveImage($request->image);
        }
        $team->facebook = $request->facebook ?? null;
        $team->linkedin = $request->linkedin ?? null;
        $team->github = $request->github ?? null;
        $team->whatsapp = $request->whatsapp ?? null;
        $team->instagram = $request->instagram ?? null;
        $team->behance = $request->behance ?? null;
        $team->youtube = $request->youtube ?? null;
        $team->upwork = $request->upwork ?? null;
        $team->fiverr = $request->fiverr ?? null;
        $team->tiktok = $request->tiktok ?? null;
        $team->portfolio = $request->portfolio ?? null;
        $team->save();
        return response()->json(['success' => true, 'data' => $team]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function listAll(Request $request)
    {
        $query = OurTeam::query();
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('name', function($query){
                return $query->name;
            })
            ->editColumn('designation', function($query){
                return $query->designation;
            })
            ->editColumn('brief', function($query){
                return $query->brief;
            })
            ->editColumn('image', function($query){
                if($query->image && $query->image != '')
                {
                $imghtml = '<div class="avatar avatar-outline">';

                    $imghtml = $imghtml.'<img src="'.asset($query->image).'" class="rounded-circle" width="50" height="50"></div>';
                }
                else{
                    $imghtml = '<span class="badge rounded-pill bg-label-danger">No Image</span>';
                }
                return $imghtml;
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
                return view('team.partials._action',['query' => $query]);
            })
            ->rawColumns(['image','action','status'])
            ->make(true);
    }

    public function removeImage(Request $request,$id)
    {
        $team = OurTeam::find($id);
        if($team)
        {
            $url = asset($team->image);
            $this->deleteImage($url);
            $team->image = null;
            $team->save();
            return response()->json(['success' => true, 'data' => $team]);
        }
        return response()->json(['success' => false, 'message' => 'Team member not found']);
    }
}
