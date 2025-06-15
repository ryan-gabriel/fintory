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

    public function bestSellerProducts()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // Get total sales for this month
        $totalSales = Sale::whereBetween('sale_date', [$startOfMonth, $endOfMonth])
            ->sum('total');

        // Get product sales using Eloquent with relationships
        $productSales = SaleItem::whereHas('sale', function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('sale_date', [$startOfMonth, $endOfMonth]);
            })
            ->with(['product.barang'])
            ->select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->get();

        // Transform data to include product names
        $productSalesWithNames = $productSales->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'product_name' => $item->product->barang->nama ?? 'Produk Tidak Diketahui',
                'total_qty' => $item->total_qty
            ];
        });

        $topProducts = $productSalesWithNames->take(5);
        $allTotalQty = $productSalesWithNames->sum('total_qty');

        $result = [];
        foreach ($topProducts as $product) {
            $percentage = $allTotalQty > 0 ? round(($product['total_qty'] / $allTotalQty) * 100, 2) : 0;
            $result[] = [
                'name' => $product['product_name'],
                'qty' => (int) $product['total_qty'],
                'percentage' => $percentage,
            ];
        }

        return response()->json([
            'products' => $result,
            'total_sales' => number_format($totalSales, 0, ',', '.'),
            'period' => [
                'start' => $startOfMonth->format('d-m-Y'),
                'end' => $endOfMonth->format('d-m-Y')
            ],
            'summary' => [
                'total_products_sold' => $topProducts->count(),
                'total_quantity_sold' => $allTotalQty
            ]
        ]);
    }
}
