<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Lembaga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user->hasAnyRole()) {
            return redirect()->route('auth.setup.lembaga');
        }

        $selectedOutletId = session('selected_outlet_id', 'all');
        $resolvedOutletId = $selectedOutletId === 'all' ? null : (int) $selectedOutletId;
        $lembagaId = session('current_lembaga_id');

        if (!$lembagaId) {
            return redirect()->route('auth.setup.lembaga')->withErrors(['Lembaga belum dipilih.']);
        }

        // === Stored Procedure Summary ===
        $summary = DB::select('CALL GetDashboardSummary(?, ?)', [$lembagaId, $resolvedOutletId]);
        $dashboardData = $summary[0] ?? null;

        // === Total Penjualan 7 Hari Terakhir ===
        $totalSalesLast7Days = Sale::whereHas('outlet', function ($query) use ($lembagaId) {
                $query->where('lembaga_id', $lembagaId);
            })
            ->when($resolvedOutletId, function ($q) use ($resolvedOutletId) {
                return $q->where('outlet_id', $resolvedOutletId);
            })
            ->where('sale_date', '>=', now()->subDays(6)->startOfDay())
            ->sum('total');

        // === Data View ===
        $viewData = [
            'totalSales' => $dashboardData->total_sales_today ?? 0,
            'totalTransaction' => $dashboardData->total_transactions_today ?? 0,
            'activeProductTotal' => $dashboardData->active_products ?? 0,
            'lowProductTotal' => $dashboardData->low_stock_products ?? 0,
            'totalSalesLast7Days' => $totalSalesLast7Days,
        ];

        if ($request->ajax()) {
            return view('dashboard', $viewData);
        }

        return view('layouts.admin', [
            'slot' => view('dashboard', $viewData),
            'title' => 'Dashboard',
            'lembaga' => Lembaga::find($lembagaId),
        ]);
    }

    public function getSalesLast7Days()
    {
        $lembagaId = session('current_lembaga_id');
        $selectedOutletId = session('selected_outlet_id', 'all');
        $resolvedOutletId = $selectedOutletId === 'all' ? null : (int) $selectedOutletId;

        if (!$lembagaId) {
            return response()->json([
                'error' => 'Lembaga tidak ditemukan dalam session.'
            ], 400);
        }

        $salesLast7Days = Sale::select(
                DB::raw('DATE(sale_date) as date'),
                DB::raw('SUM(total) as total')
            )
            ->whereHas('outlet', function ($q) use ($lembagaId) {
                $q->where('lembaga_id', $lembagaId);
            })
            ->when($resolvedOutletId, function ($q) use ($resolvedOutletId) {
                return $q->where('outlet_id', $resolvedOutletId);
            })
            ->where('sale_date', '>=', now()->subDays(6)->startOfDay())
            ->groupBy(DB::raw('DATE(sale_date)'))
            ->orderBy('date', 'ASC')
            ->get()
            ->keyBy('date');

        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $carbonDate = now()->subDays($i);
            $dateKey = $carbonDate->toDateString();
            $formattedDate = $carbonDate->format('d M');

            $chartData[] = [
                'date' => $formattedDate,
                'total' => isset($salesLast7Days[$dateKey]) ? (float) $salesLast7Days[$dateKey]->total : 0,
            ];
        }

        return response()->json($chartData);
    }

    public function bestSellerProducts()
    {
        $lembagaId = session('current_lembaga_id');
        $selectedOutletId = session('selected_outlet_id', 'all');
        $resolvedOutletId = $selectedOutletId === 'all' ? null : (int) $selectedOutletId;

        if (!$lembagaId) {
            return response()->json([
                'error' => 'Lembaga tidak ditemukan dalam session.'
            ], 400);
        }

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $totalSales = Sale::whereHas('outlet', function ($q) use ($lembagaId) {
                $q->where('lembaga_id', $lembagaId);
            })
            ->when($resolvedOutletId, function ($q) use ($resolvedOutletId) {
                return $q->where('outlet_id', $resolvedOutletId);
            })
            ->whereBetween('sale_date', [$startOfMonth, $endOfMonth])
            ->sum('total');

        $topProducts = DB::table('best_seller_products_monthly')
            ->where('lembaga_id', $lembagaId)
            ->when($resolvedOutletId, function ($q) use ($resolvedOutletId) {
                return $q->where('outlet_id', $resolvedOutletId);
            })
            ->orderBy('rank_num')
            ->limit(5)
            ->get();

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
