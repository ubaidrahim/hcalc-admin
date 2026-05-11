<?php

namespace App;

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
        $statsArr = [];
        $statsArr['mostviewedCount'] = $mostviewed ? $mostviewed->total_count : 0;
        $statsArr['mostviewedName'] = $mostviewed && $mostviewed->calculator ? $mostviewed->calculator->title : '--Nothing Found--';
        $statsArr['growth'] = $calculationstats->growth_percentage;
        $statsArr['countries'] = self::formatNumber($countries);
        $statsArr['visitors'] = self::formatNumber($vistors);
        $statsArr['pageviews'] = self::formatNumber($pageviews);
        $statsArr['calculations'] = self::formatNumber($calculationstats->last_30_days_calculations);
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
