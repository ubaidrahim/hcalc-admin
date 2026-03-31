<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Visitor;
use Carbon\Carbon;

class VisitorsController extends Controller
{
    public function index()
    {
        return view('visitors.index');
    }

    public function listAll(Request $request)
    {
        $query = Visitor::with('pageviews','calculations')->latest();
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('visitorid', function($query){
                return $query->id;
            })
            ->editColumn('ipaddress', function($query){
                return $query->ip;
            })
            ->editColumn('city', function($query){
                return $query->city ?? '';
            })
            ->editColumn('country', function($query){
                return $query->country ?? '';
            })
            ->editColumn('pageviews', function($query){
                return count($query->pageviews);
            })
            ->editColumn('calculations', function($query){
                return count($query->calculations);
            })
            ->editColumn('calculations', function($query){
                return count($query->calculations);
            })
            ->editColumn('createdat', function($query){
                return Carbon::parse($query->created_at)->format(formatted_date());
            })
            ->editColumn('lastactivity', function($query){
                return view('visitors.last_activity',['activity' => $query->last_activity]);
            })
            ->rawColumns(['lastactivity'])
            ->make(true);
    }
}
