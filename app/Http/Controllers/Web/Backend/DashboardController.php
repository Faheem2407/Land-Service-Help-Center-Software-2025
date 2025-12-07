<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Receiver;
use App\Models\Cost;
use App\Models\Transaction;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $sumTransaction = fn($type, $date = null) => Transaction::when($date, fn($q) => $q->whereDate('created_at', $date))
            ->where('type', $type)
            ->sum('amount');

        return view('backend.layouts.index', [
            'total_users' => User::count(),
            'today_receivers' => Receiver::whereDate('created_at', today())->count(),
            'total_receivers' => Receiver::count(),
            'today_processing_charge' => $sumTransaction('processing', today()),
            'total_processing_charge' => $sumTransaction('processing'),
            'today_online_charge' => $sumTransaction('online', today()),
            'total_online_charge' => $sumTransaction('online'),
            'today_costs' => Cost::whereDate('date', today())->sum('amount'),
            'total_costs' => Cost::sum('amount'),
            'today_total_revenue' => $sumTransaction('processing', today()) + $sumTransaction('online', today()),
            'total_revenue' => $sumTransaction('processing') + $sumTransaction('online'),
        ]);
    }
}
