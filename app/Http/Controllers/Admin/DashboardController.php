<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $currentYear = now()->year;
        $monthlyEarnings = array_fill(1, 12, 0);
        $monthlyTotals = DB::table('payments')
                        ->select(
                            DB::raw('SUM(amount) as total_amount'), 
                            DB::raw('MONTH(created_at) as month')
                        )
                        ->whereYear('created_at', $currentYear) 
                        ->groupBy('month')
                        ->get();
        foreach ($monthlyTotals as $monthlyTotal) {
            $monthlyEarnings[$monthlyTotal->month] = (float) $monthlyTotal->total_amount;
        }
        $totalsByPackage = DB::table('payments')
                            ->join('packages', 'payments.package_id', '=', 'packages.id')
                            ->select('packages.name as package_name', DB::raw('SUM(payments.amount) as total_amount'))
                            ->whereYear('payments.created_at', $currentYear)
                            ->groupBy('packages.name')
                            ->get();
        return view('admin.index',compact('monthlyEarnings','totalsByPackage'));
    }
}
