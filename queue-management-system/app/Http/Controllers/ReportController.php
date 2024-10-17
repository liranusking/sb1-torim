<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function getServiceStats(Request $request)
    {
        $stats = Service::withCount('appointments')
            ->withAvg('appointments', 'price')
            ->get();

        return response()->json($stats);
    }

    public function getAppointmentStats(Request $request)
    {
        $stats = Appointment::select(
            DB::raw('DATE(start_time) as date'),
            DB::raw('COUNT(*) as total_appointments'),
            DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_appointments')
        )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($stats);
    }

    public function getRevenueStats(Request $request)
    {
        $stats = Appointment::select(
            DB::raw('DATE(start_time) as date'),
            DB::raw('SUM(price) as total_revenue')
        )
            ->where('status', 'completed')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($stats);
    }
}