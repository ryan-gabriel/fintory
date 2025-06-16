<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
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

        // Ambil outlet_id yang aktif dari session, defaultnya 'all'
        $activeOutletId = session('active_outlet_id', 'all');
        $lembaga_id = session('current_lembaga_id');

        // Panggil Stored Procedure dengan satu panggilan database
        $summary = DB::select('CALL GetDashboardSummary(?)', [$activeOutletId]);
        
        // Ambil hasil dari baris pertama result set
        $dashboardData = $summary[0] ?? null;

        // Siapkan data untuk dikirim ke view, dengan nilai default 0 jika data tidak ada
        $viewData = [
            'totalSales' => $dashboardData->total_sales_today ?? 0,
            'totalTransaction' => $dashboardData->total_transactions_today ?? 0,
            'activeProductTotal' => $dashboardData->active_products ?? 0,
            'lowProductTotal' => $dashboardData->low_stock_products ?? 0,
        ];
        
        // Method lain untuk chart bisa dipanggil terpisah jika diperlukan
        $totalSalesLast7Days = Sale::where('sale_date', '>=', now()->subDays(6)->startOfDay())->sum('total');
        $viewData['totalSalesLast7Days'] = $totalSalesLast7Days;

        return view('dashboard', $viewData);
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

    public function bestSellerProducts()
{
    $startOfMonth = now()->startOfMonth();
    $endOfMonth = now()->endOfMonth();

    $totalSales = Sale::whereBetween('sale_date', [$startOfMonth, $endOfMonth])
        ->sum('total');

    // Ambil data dari view
    $topProducts = DB::table('best_seller_products_monthly')->get();

    $allTotalQty = $topProducts->sum('total_qty');

    $result = $topProducts->map(function ($product) use ($allTotalQty) {
        $percentage = $allTotalQty > 0 ? round(($product->total_qty / $allTotalQty) * 100, 2) : 0;

        return [
            'name' => $product->product_name,
            'qty' => (int) $product->total_qty,
            'percentage' => $percentage,
        ];
    });

    return response()->json([
        'products' => $result,
        'total_sales' => number_format($totalSales, 0, ',', '.'),
        'period' => [
            'start' => $startOfMonth->format('d-m-Y'),
            'end' => $endOfMonth->format('d-m-Y')
        ],
        'summary' => [
            'total_products_sold' => count($result),
            'total_quantity_sold' => $allTotalQty
        ]
    ]);
}

}
