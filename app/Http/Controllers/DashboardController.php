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
        
        // Redirect jika belum punya role apapun
        if (!$user->hasAnyRole()) {
            return redirect()->route('auth.setup.lembaga');
        }

        // Ambil outlet aktif dan lembaga aktif dari session
        $activeOutletId = session('active_outlet_id', 'all');
        $lembaga_id = session('current_lembaga_id');

        if (!$lembaga_id) {
            return redirect()->route('auth.setup.lembaga')->withErrors(['Lembaga belum dipilih.']);
        }

        // Panggil stored procedure dengan outlet ID
        $summary = DB::select('CALL GetDashboardSummary(?, ?)', [$lembaga_id, $activeOutletId]);

        $dashboardData = $summary[0] ?? null;

        // Data default
        $viewData = [
            'totalSales' => $dashboardData->total_sales_today ?? 0,
            'totalTransaction' => $dashboardData->total_transactions_today ?? 0,
            'activeProductTotal' => $dashboardData->active_products ?? 0,
            'lowProductTotal' => $dashboardData->low_stock_products ?? 0,
        ];

        // Hitung total penjualan 7 hari terakhir berdasarkan lembaga
        $totalSalesLast7Days = \App\Models\Sale::whereHas('outlet', function ($query) use ($lembaga_id) {
            $query->where('lembaga_id', $lembaga_id);
        })
        ->where('sale_date', '>=', now()->subDays(6)->startOfDay())
        ->sum('total');


        $viewData['totalSalesLast7Days'] = $totalSalesLast7Days;

        return view('dashboard', $viewData);
    }


    public function getSalesLast7Days()
    {
        $currentLembagaId = session('current_lembaga_id');

        if (!$currentLembagaId) {
            return response()->json([
                'error' => 'Lembaga tidak ditemukan dalam session.'
            ], 400);
        }

        $salesLast7Days = \App\Models\Sale::select(
                DB::raw('DATE(sale_date) as date'),
                DB::raw('SUM(total) as total')
            )
            ->where('sale_date', '>=', now()->subDays(6)->startOfDay())
            ->whereHas('outlet', function ($q) use ($currentLembagaId) {
                $q->where('lembaga_id', $currentLembagaId);
            })
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
        $currentLembagaId = session('current_lembaga_id');

        if (!$currentLembagaId) {
            return response()->json([
                'error' => 'Lembaga tidak ditemukan dalam session.'
            ], 400);
        }

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // Total penjualan lembaga ini dalam bulan ini
        $totalSales = Sale::whereHas('outlet', function ($q) use ($currentLembagaId) {
                $q->where('lembaga_id', $currentLembagaId);
            })
            ->whereBetween('sale_date', [$startOfMonth, $endOfMonth])
            ->sum('total');

        // Ambil data best seller dari view berdasarkan lembaga
        $topProducts = DB::table('best_seller_products_monthly')
            ->where('lembaga_id', $currentLembagaId)
            ->orderBy('rank_num')
            ->limit(5)
            ->get();

        // Total kuantitas dari semua produk yang terambil
        $allTotalQty = $topProducts->sum('total_qty');

        // Format data untuk output
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
