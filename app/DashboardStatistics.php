<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Calculator;
use App\Models\Visitor;
use App\Models\TrackVisitor;
use App\Models\Calculation;


class DashboardStatistics
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function getAllStaticAnalytics()
    {
        $mostviewed = Calculation::selectRaw('COUNT(*) as total_count, calculator_id')
            ->with('calculator')
            ->whereBetween('created_at', [
                now()->subDays(30)->startOfDay(),
                now()->endOfDay()
            ])
            ->groupBy('calculator_id')
            ->orderBy('total_count','desc')
            ->first();
        $countries = Visitor::whereBetween('created_at', [
                now()->subDays(30)->startOfDay(),
                now()->endOfDay()
            ])
            ->distinct('country')
            ->count('country');
        $vistors = Visitor::whereBetween('created_at', [
                now()->subDays(30)->startOfDay(),
                now()->endOfDay()
            ])
            ->count();
        $recentVisitors = Visitor::orderBy('created_at','desc')
            ->limit(10)
            ->get();
        // $recentVisitors = Visitor::whereBetween('created_at', [
        //         now()->subDays(30)->startOfDay(),
        //         now()->endOfDay()
        //     ])
        //     ->orderBy('created_at','desc')
        //     ->limit(10)
        //     ->get();
        $topcalcs = Calculation::selectRaw('COUNT(id) as total_count, calculator_id')
            ->with('calculator')
            ->whereBetween('created_at', [
                now()->subDays(30)->startOfDay(),
                now()->endOfDay()
            ])
            ->groupBy('calculator_id')
            ->orderBy('total_count','desc')
            ->limit(3)
            ->get();
        $allactivity = TrackVisitor::whereBetween('created_at', [
                now()->subDays(30)->startOfDay(),
                now()->endOfDay()
            ])
            ->count();
        $lastMonthActivity = TrackVisitor::whereBetween('created_at', [
            now()->subDays(60)->startOfDay(),
            now()->subDays(30)->startOfDay()
            ])
            ->count();
        $activityFlag = 0; // 0 = down, 1 = up, 2 = no change

        if ($lastMonthActivity > 0) {
            $activityPct = round((($allactivity - $lastMonthActivity) / $lastMonthActivity) * 100);

            if ($activityPct > 0) {
                $activityFlag = 1; // Up
            } elseif ($activityPct < 0) {
                $activityFlag = 0; // Down
                $activityPct = abs($activityPct); // Optional: show positive percentage
            } else {
                $activityFlag = 2; // No change
            }
        } else {
            // Last month was zero
            if ($allactivity > 0) {
                $activityPct = 100;      // or treat as infinite growth
                $activityFlag = 1;
            } else {
                $activityPct = 0;
                $activityFlag = 2;
            }
        }
        $pageviews = TrackVisitor::whereBetween('created_at', [
                now()->subDays(30)->startOfDay(),
                now()->endOfDay()
            ])
            ->where('event_type','page_view')
            ->count();
        $calculationstats = Calculation::selectRaw("
            COUNT(*) as total_calculations,
            
            SUM(
                CASE 
                    WHEN created_at BETWEEN ? AND ? 
                    THEN 1 
                    ELSE 0 
                END
            ) as last_30_days_calculations,

            ROUND(
                (
                    SUM(
                        CASE 
                            WHEN created_at BETWEEN ? AND ? 
                            THEN 1 
                            ELSE 0 
                        END
                    ) / COUNT(*)
                ) * 100,
                2
            ) as growth_percentage
        ", [
            now()->subDays(30)->startOfDay(),
            now()->endOfDay(),

            now()->subDays(30)->startOfDay(),
            now()->endOfDay()
        ])
        ->first();
        $weekStartDate = Carbon::now()->subWeeks(3)->startOfWeek();
        $weeklyOverview = [];
        for ($i = 3; $i >= 0; $i--) {

            $start = Carbon::now()->subWeeks($i)->startOfWeek();
            $end = Carbon::now()->subWeeks($i)->endOfWeek();

            $weeklyOverview[] = [
                'week' => $start->format('d M') . ' - ' . $end->format('d M'),
                'count' => TrackVisitor::whereBetween('created_at', [$start, $end])->count(),
            ];
        }
        $statsArr = [];
        $statsArr['mostviewedCount'] = $mostviewed ? $mostviewed->total_count : 0;
        $statsArr['mostviewedName'] = $mostviewed && $mostviewed->calculator ? $mostviewed->calculator->title : '--Nothing Found--';
        $statsArr['growth'] = $calculationstats->growth_percentage;
        $statsArr['countries'] = self::formatNumber($countries);
        $statsArr['visitors'] = self::formatNumber($vistors);
        $statsArr['recentVisitors'] = $recentVisitors;
        $statsArr['pageviews'] = self::formatNumber($pageviews);
        $statsArr['calculations'] = self::formatNumber($calculationstats->last_30_days_calculations);
        $statsArr['weeklyOverview'] = $weeklyOverview;
        $statsArr['allactivity'] = $allactivity;
        $statsArr['lastMonthActivity'] = $lastMonthActivity;
        $statsArr['activityPct'] = $activityPct;
        $statsArr['activityFlag'] = $activityFlag;
        $statsArr['topcalcs'] = $topcalcs;
        return $statsArr;
    }

    public static function formatNumber($number)
    {
        if ($number >= 1000000000) {
            return round($number / 1000000000, 1) . 'B';
        }

        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        }

        if ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        }

        return $number;
    }
}
