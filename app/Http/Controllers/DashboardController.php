<?php

namespace App\Http\Controllers;

use App\Models\Lembaga;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user->hasAnyRole()) {
            return redirect()->route('auth.setup.lembaga');
        }

        $lembagaId = session('current_lembaga_id');
        if (!$lembagaId) {
            return redirect()->route('auth.setup.lembaga')->withErrors(['Lembaga belum dipilih.']);
        }

        $selectedOutletId = session('selected_outlet_id', 'all');
        $resolvedOutletId = $selectedOutletId === 'all' ? null : (int) $selectedOutletId;

        // --- Mulai Caching ---
        $cacheDuration = now()->addHour(); // Durasi cache 1 jam

        // Kunci cache yang unik berdasarkan lembaga dan outlet
        $summaryCacheKey = "dashboard:summary:lembaga_{$lembagaId}:outlet_{$resolvedOutletId}";
        $totalSales7DaysCacheKey = "dashboard:total_sales_7_days:lembaga_{$lembagaId}:outlet_{$resolvedOutletId}";

        // === Stored Procedure Summary (Cached) ===
        $dashboardData = Cache::remember($summaryCacheKey, $cacheDuration, function () use ($lembagaId, $resolvedOutletId) {
            $summary = DB::select('CALL GetDashboardSummary(?, ?)', [$lembagaId, $resolvedOutletId]);
            return $summary[0] ?? null;
        });

        // === Total Penjualan 7 Hari Terakhir (Cached) ===
        $totalSalesLast7Days = Cache::remember($totalSales7DaysCacheKey, $cacheDuration, function () use ($lembagaId, $resolvedOutletId) {
            return Sale::whereHas('outlet', function ($query) use ($lembagaId) {
                $query->where('lembaga_id', $lembagaId);
            })
                ->when($resolvedOutletId, function ($q) use ($resolvedOutletId) {
                    return $q->where('outlet_id', $resolvedOutletId);
                })
                ->where('sale_date', '>=', now()->subDays(6)->startOfDay())
                ->sum('total');
        });

        // === Data Lembaga (Bisa juga di-cache jika diinginkan) ===
        $lembaga = Cache::remember("lembaga:{$lembagaId}", $cacheDuration, function () use ($lembagaId) {
            return Lembaga::find($lembagaId);
        });

        // --- Akhir Caching ---

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
            'lembaga' => $lembaga,
        ]);
    }

    public function getSalesLast7Days()
    {
        $lembagaId = session('current_lembaga_id');
        if (!$lembagaId) {
            return response()->json(['error' => 'Lembaga tidak ditemukan dalam session.'], 400);
        }

        $selectedOutletId = session('selected_outlet_id', 'all');
        $resolvedOutletId = $selectedOutletId === 'all' ? null : (int) $selectedOutletId;

        // Kunci cache yang unik untuk chart
        $cacheKey = "dashboard:chart_sales_7_days:lembaga_{$lembagaId}:outlet_{$resolvedOutletId}";
        $cacheDuration = now()->addHour();

        $chartData = Cache::remember($cacheKey, $cacheDuration, function () use ($lembagaId, $resolvedOutletId) {
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

            $data = [];
            for ($i = 6; $i >= 0; $i--) {
                $carbonDate = now()->subDays($i);
                $dateKey = $carbonDate->toDateString();
                $formattedDate = $carbonDate->format('d M');

                $data[] = [
                    'date' => $formattedDate,
                    'total' => isset($salesLast7Days[$dateKey]) ? (float) $salesLast7Days[$dateKey]->total : 0,
                ];
            }
            return $data;
        });

        return response()->json($chartData);
    }

    public function bestSellerProducts()
    {
        $lembagaId = session('current_lembaga_id');
        if (!$lembagaId) {
            return response()->json(['error' => 'Lembaga tidak ditemukan dalam session.'], 400);
        }

        $selectedOutletId = session('selected_outlet_id', 'all');
        $resolvedOutletId = $selectedOutletId === 'all' ? null : (int) $selectedOutletId;

        // Kunci cache yang unik untuk produk terlaris
        $cacheKey = "dashboard:bestseller_monthly:lembaga_{$lembagaId}:outlet_{$resolvedOutletId}";
        $cacheDuration = now()->addHour();

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $data = Cache::remember($cacheKey, $cacheDuration, function () use ($lembagaId, $resolvedOutletId, $startOfMonth, $endOfMonth) {
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

            return [
                'products' => $result,
                'total_sales' => number_format($totalSales, 0, ',', '.'),
                'period' => [
                    'start' => $startOfMonth->format('d-m-Y'),
                    'end' => $endOfMonth->format('d-m-Y'),
                ],
                'summary' => [
                    'total_products_sold' => count($result),
                    'total_quantity_sold' => $allTotalQty,
                ],
            ];
        });

        return response()->json($data);
    }
}
