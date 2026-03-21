<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // --- Time Period Filter ---
        $period = $request->input('period', 'last_30_days');
        $startDate = match ($period) {
            'last_7_days' => Carbon::now()->subDays(7),
            'last_90_days' => Carbon::now()->subDays(90),
            'all_time' => null,
            default => Carbon::now()->subDays(30), // last_30_days
        };

        // --- Key Metrics ---
        $rentalsQuery = Rental::query();

        if ($startDate) {
            $rentalsQuery->where('created_at', '>=', $startDate);
        }

        // Use a cloned query for revenue calculation on completed rentals
        $revenueQuery = $rentalsQuery->clone()->where('status', 'completed');

        $stats = [
            'total_revenue' => $revenueQuery->sum('total_price'),
            'total_rentals' => $rentalsQuery->count(),
            'pending_rentals' => Rental::where('status', 'pending')->count(), // This is always total pending, not period-specific
            'available_vehicles' => Vehicle::where('status', 'available')->count(),
            'period' => $period,
        ];

        // --- Chart Data: Rentals per day for the last 30 days ---
        $rentalsChartQuery = Rental::query()->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as count')
        )->where('created_at', '>=', Carbon::now()->subDays(30))->groupBy('date')->orderBy('date', 'ASC');

        $rentalsPerDay = $rentalsChartQuery->get()->pluck('count', 'date');

        // Fill in missing dates with 0 for a continuous chart
        $chartData = [];
        $chartLabels = [];
        $dateIterator = Carbon::now()->subDays(29);
        while ($dateIterator <= Carbon::now()) {
            $formattedDate = $dateIterator->format('Y-m-d');
            $chartLabels[] = $dateIterator->format('M d');
            $chartData[] = $rentalsPerDay[$formattedDate] ?? 0;
            $dateIterator->addDay();
        }

        $charts = [
            'rentals' => [
                'labels' => $chartLabels,
                'data' => $chartData,
            ],
        ];

        return view('admin.reports.index', compact('stats', 'charts'));
    }
}