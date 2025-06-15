<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user->hasAnyRole()) {
            return redirect()->route('auth.setup.lembaga');
        }

        // Ringkasan harian
        $sales = Sale::whereDate('sale_date', now()->toDateString())->get();
        $totalSales = $sales->sum(fn($sale) => $sale->total ?? 0);
        $totalTransaction = $sales->count();
        $lowProductTotal = Product::where('stok', '<', 10)->count();
        $activeProductTotal = Product::where('is_active', 1)->count();

        $totalSalesLast7Days = Sale::where('sale_date', '>=', now()->subDays(6)->startOfDay())
            ->sum('total');

        return view('dashboard', compact(
            'totalSales',
            'totalTransaction',
            'lowProductTotal',
            'activeProductTotal',
            'totalSalesLast7Days'
        ));
    }

    public function getSalesLast7Days()
    {
        $salesLast7Days = \App\Models\Sale::select(
                DB::raw('DATE(sale_date) as date'),
                DB::raw('SUM(total) as total')
            )
            ->where('sale_date', '>=', now()->subDays(6)->startOfDay())
            ->groupBy(DB::raw('DATE(sale_date)'))
            ->orderBy('date', 'ASC')
            ->get()
            ->keyBy('date');

        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $carbonDate = now()->subDays($i);
            $dateKey = $carbonDate->toDateString(); // e.g. 2025-06-09
            $formattedDate = $carbonDate->format('d M'); // e.g. 09 Jun

            $chartData[] = [
                'date' => $formattedDate,
                'total' => isset($salesLast7Days[$dateKey]) ? (float) $salesLast7Days[$dateKey]->total : 0,
            ];
        }

        return response()->json($chartData);
    }
}
