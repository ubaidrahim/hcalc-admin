<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\SiteScript;
use App\Models\Category;
use App\Models\Calculator;


class SiteScriptsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sitescripts.index');
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
           'name' => 'required',
           'type' => 'required',
           'placement' => 'required',
           'measurement_id' => 'required_if:type,gtag,gmt',
           'client_id' => 'required_if:type,adsense',
           'meta_name' => 'required_if:type,meta_tag',
           'meta_value' => 'required_if:type,meta_tag',
           'url_source' => 'required_if:type,external_src',
        ]);

        switch ($request->type) {
            case 'gtag':
                $config_json = [
                    'measurement_id' => $request->measurement_id,
                ];
                break;
            case 'gmt':
                $config_json = [
                    'measurement_id' => $request->measurement_id,
                ];
                break;
            case 'adsense':
                $config_json = [
                    'client_id' => $request->client_id,
                ];
                break;
            case 'meta_tag':
                $config_json = [
                    'meta_name' => $request->meta_name,
                    'meta_value' => $request->meta_value,
                ];
                break;
            case 'external_src':
                $config_json = [
                    'url_source' => $request->url_source,
                ];
                break;
            
            default:
                $config_json = null;
                break;
        }

        if($request->type == 'gtag' || $request->type == 'gmt')
        {
            $script = SiteScript::where('type',$request->type)->first();
            if($script)
            {
                return response()->json(['success' => false, 'message' => 'GTAG/GMT Script already exists']);
            }
        }
        if($request->type == 'adsense')
        {
            $script = SiteScript::where('type',$request->type)->first();
            if($script)
            {
                return response()->json(['success' => false, 'message' => 'Adsense Script already exists']);
            }
        }
        $script = new SiteScript();
        $script->name = $request->name;
        $script->type = $request->type;
        $script->placement = $request->placement;
        $script->config_json = $config_json ? json_encode($config_json) : null;
        $script->save();
        return response()->json(['success' => true, 'data' => $script]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $script = SiteScript::find($id);
        if($script)
        {
            return response()->json(['success' => true, 'data' => $script]);
        }
        return response()->json(['success' => false, 'message' => 'Script not found']);
    }

    public function search(string $type)
    {
        $script = SiteScript::where('type',$type)->first();
        if($script)
        {
            return response()->json(['success' => true, 'data' => $script]);
        }
        return response()->json(['success' => false]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
           'name' => 'required',
           'type' => 'required',
           'placement' => 'required',
           'measurement_id' => 'required_if:type,gtag,gmt',
           'client_id' => 'required_if:type,adsense',
           'meta_name' => 'required_if:type,meta_tag',
           'meta_value' => 'required_if:type,meta_tag',
           'url_source' => 'required_if:type,external_src',
        ]);

        switch ($request->type) {
            case 'gtag':
                $config_json = [
                    'measurement_id' => $request->measurement_id,
                ];
                break;
            case 'gmt':
                $config_json = [
                    'measurement_id' => $request->measurement_id,
                ];
                break;
            case 'adsense':
                $config_json = [
                    'client_id' => $request->client_id,
                ];
                break;
            case 'meta_tag':
                $config_json = [
                    'meta_name' => $request->meta_name,
                    'meta_value' => $request->meta_value,
                ];
                break;
            case 'external_src':
                $config_json = [
                    'url_source' => $request->url_source,
                ];
                break;
            default:
                $config_json = null;
                break;
        }

        $script = SiteScript::find($id);
        $script->name = $request->name;
        $script->type = $request->type;
        $script->placement = $request->placement;
        $script->config_json = $config_json ? json_encode($config_json) : null;
        $script->save();
        return response()->json(['success' => true, 'data' => $script]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function listAll()
    {
        $query = SiteScript::latest();
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('name', function($query){
                return $query->name;
            })
            ->editColumn('type', function($query){
                return $query->type;
            })
            ->editColumn('placement', function($query){
                return $query->placement;
            })
            ->editColumn('config_json', function($query){
                $config_json = json_decode($query->config_json, true);
                if($config_json)
                {
                    return '<pre>' . json_encode($config_json, JSON_PRETTY_PRINT) . '</pre>';
                }
                return '-';
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
                // return '';
                return view('sitescripts._actions',['query' => $query]);
            })
            ->rawColumns(['action','status','config_json'])
            ->make(true);
    }
}
