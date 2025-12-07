<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cost;
use App\Models\CostSource;
use App\Models\Receiver;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    // Revenue Report
    public function revenue(Request $request): View
    {
        $query = Receiver::query();

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('date', [$request->date_from, $request->date_to]);
        }

        $receivers = $query->latest()->get();

        // Total Revenue
        $totalRevenue = $receivers->sum('total_charge');

        return view('backend.admin.reports.revenue', compact('receivers', 'totalRevenue'));
    }

    public function cost(Request $request): View
    {
        $query = Cost::query()->with('source');

        // Filter by date range
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('date', [$request->date_from, $request->date_to]);
        }

        // Filter by cost source
        if ($request->filled('cost_source_id')) {
            $query->where('cost_source_id', $request->cost_source_id);
        }

        $costs = $query->latest()->get();

        // Total cost
        $totalCost = $costs->sum('amount');

        // All cost sources for dropdown
        $sources = CostSource::all();

        return view('backend.admin.reports.cost', compact('costs', 'totalCost', 'sources'));
    }


    // Cash Book Report
    public function cashBook(Request $request): View
    {
        $revenues = Receiver::query();
        $costs = Cost::query();

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $revenues->whereBetween('date', [$request->date_from, $request->date_to]);
            $costs->whereBetween('date', [$request->date_from, $request->date_to]);
        }

        $revenues = $revenues->latest()->get();
        $costs = $costs->latest()->get();

        $totalRevenue = $revenues->sum('total_charge');
        $totalCost = $costs->sum('amount');
        $balance = $totalRevenue - $totalCost;

        return view('backend.admin.reports.cash_book', compact('revenues', 'costs', 'totalRevenue', 'totalCost', 'balance'));
    }
}

