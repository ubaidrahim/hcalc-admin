<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OurTeam;

class TeamController extends Controller
{
    public function index()
    {
        $team = OurTeam::where('status',1)->orderBy('id','asc')->get();
        $members = [];
        foreach ($team as $key => $item) {
            $members[] = [
                'id' => $item->id,
                'name' => $item->name ?? null,
                'designation' => $item->designation ?? null,
                'brief' => $item->brief ?? null,
                'image' => $item->image ? asset($item->image) : null,
                'facebook' => $item->facebook ?? null,
                'linkedin' => $item->linkedin ?? null,
                'github' => $item->github ?? null,
                'whatsapp' => $item->whatsapp ?? null,
                'instagram' => $item->instagram ?? null,
                'behance' => $item->behance ?? null,
                'youtube' => $item->youtube ?? null,
                'tiktok' => $item->tiktok ?? null,
                'upwork' => $item->upwork ?? null,
                'fiverr' => $item->fiverr ?? null,
                'portfolio' => $item->portfolio ?? null
            ];
        }
        return response()->json(['success' => true, 'data' => $members]);
    }
}
