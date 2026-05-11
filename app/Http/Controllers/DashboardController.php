<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DashboardStatistics;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = DashboardStatistics::getAllStaticAnalytics();
        return view('dashboard',get_defined_vars());
    }
}
