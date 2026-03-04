<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Visitor;
use App\Models\TrackVisitor;

class VisitorsController extends Controller
{
    public function init(Request $request)
    {
        // If frontend already has uuid, return existing visitor
        $uuid = $request->input('visitor_uuid');
        if ($uuid) {
            $existing = Visitor::where('visitor_uuid', $uuid)->first();
            if ($existing) {
                return response()->json([
                    'success' => true,
                    'visitor_uuid' => $existing->visitor_uuid,
                    'visitor_db_id' => $existing->id,
                    'is_new' => false,
                ]);
            }
        }

        try {
            $location = geoip(request()->ip());

            $country = $location->country;
            $city = $location->city;

        } catch (\Exception $e) {

            $country = null;
            $city = null;

            // Optional: log error
            \Log::warning('GeoIP lookup failed: ' . $e->getMessage());
        }

        return DB::transaction(function () use ($request) {

            $visitor = Visitor::create([
                'visitor_uuid' => (string) Str::uuid(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'city' => $city,
                'country' => $country,
            ]);

            return response()->json([
                'success' => true,
                'visitor_uuid' => $visitor->visitor_uuid,
                'visitor_db_id' => $visitor->id,
                'is_new' => true,
            ]);
        });
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'visitor_uuid' => ['required', 'uuid'],
            'url'         => ['required', 'string'],
            'referrer'    => ['nullable', 'string'],
            'user_agent'  => ['nullable', 'string'],
            'event_type'  => ['nullable', 'string', 'max:50'],
            'meta'        => ['nullable', 'array'],
        ]);

        $visitor = Visitor::where('visitor_uuid', $data['visitor_uuid'])->first();

        // If visitor_uuid is missing in DB (cleared DB, new deploy etc) you can either:
        // (A) return 404, or (B) auto-create a visitor again.
        if (!$visitor) {
            return response()->json(['success' => false, 'message' => 'Visitor not found'], 404);
        }

        $event = TrackVisitor::create([
            'visitor_id' => $visitor->id,
            'event_type' => $data['event_type'] ?? 'page_view',
            'url'        => $data['url'],
            'referrer'   => $data['referrer'] ?? null,
            'user_agent' => $data['user_agent'] ?? null,
            'ip'         => $request->ip(),
            'meta'       => $data['meta'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'event_id' => $event->id
        ]);
    }
}
