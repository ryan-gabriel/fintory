<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    /**
     * Menampilkan halaman riwayat penjualan.
     */
    public function index(Request $request)
    {
        $view = view('penjualan.index'); // <-- HAPUS compact('sales') DARI SINI

        if ($request->ajax()) {
            return $view;
        }

        return view('layouts.admin', [
            'slot' => $view,
            'title' => 'Riwayat Penjualan',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    public function getData(Request $request)
    {
        $query = Sale::with(['outlet']); // Relasi yang dibutuhkan

        // ▼▼▼ LOGIKA FILTER PENCARIAN (SEARCH) ▼▼▼
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhere('total', 'like', "%{$search}%")
                    ->orWhereHas('outlet', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Logika filter global berdasarkan outlet yang aktif
        $activeOutletId = session('selected_outlet_id');
        if ($activeOutletId && $activeOutletId !== 'all') {
            $query->where('outlet_id', $activeOutletId);
        }

        if ($request->filled('start_date')) {
            try {
                // Konversi format dari datepicker ke format database
                $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', $request->start_date)->startOfDay();
                if ($request->filled('end_date')) {
                    $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', $request->end_date)->endOfDay();
                } else {
                    $endDate = now()->endOfDay();
                }
                $query->whereBetween('sale_date', [$startDate, $endDate]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Invalid date format in Sale report: ' . $request->start_date . ' or ' . $request->end_date);
            }
        }



        $totalFiltered = $query->count();

        // Ordering
        $orderColIndex = $request->input('order.0.column', 0);
        $orderDir = strtolower($request->input('order.0.dir', 'desc')) === 'desc' ? 'desc' : 'asc';
        $orderColName = $columns[$orderColIndex] ?? 'sale_date';

        if ($orderColName === 'outlet.name') {
            $query->join('outlet', 'outlet.id', '=', 'sale.outlet_id')
                ->orderBy('outlet.name', $orderDir)
                ->select('sale.*');
        } else {
            $query->orderBy($orderColName, $orderDir);
        }

        $data = $query->offset($request->start)->limit($request->length)->get();

        // Format data untuk response JSON
        $jsonData = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => Sale::count(),
            "recordsFiltered" => $totalFiltered,
            "data" => []
        ];

        foreach ($data as $sale) {
            // Data dimasukkan sebagai array, bukan objek dengan key
            $jsonData['data'][] = [
                \Carbon\Carbon::parse($sale->sale_date)->format('d M Y'),
                'TRX-' . str_pad($sale->id, 5, '0', STR_PAD_LEFT),
                $sale->outlet->name ?? 'N/A',
                $sale->customer_name,
                'Rp ' . number_format($sale->total, 0, ',', '.'),
                '<a href="' . route('penjualan.show', $sale->id) . '" class="text-indigo-600 hover:underline font-medium">Detail</a>'
            ];
        }

        return response()->json($jsonData);
    }

    /**
     * Menampilkan form untuk membuat transaksi baru.
     */
    public function create(Request $request)
    {
        $lembaga_id = session('current_lembaga_id');
        $data = [
            'outlets' => Outlet::where('lembaga_id', $lembaga_id)->orderBy('name')->get(),
        ];

        $view = view('penjualan.create', $data);

        if ($request->ajax()) {
            return $view;
        }

        return view('layouts.admin', [
            'slot' => $view,
            'title' => 'Buat Transaksi Penjualan',
            'lembaga' => Lembaga::find($lembaga_id),
        ]);
    }

    /**
     * Menyimpan transaksi baru dari form ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'outlet_id' => 'required|exists:outlet,id',
            'customer_name' => 'required|string|max:100',
            'products' => 'required|array|min:1',
            'products.*' => 'required|exists:product,id',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
        ], ['products.required' => 'Keranjang belanja tidak boleh kosong.']);

        try {
            DB::transaction(function () use ($validated) {
                $total = 0;
                $cartItemsForInsert = [];

                foreach ($validated['products'] as $index => $productId) {
                    $product = \App\Models\Product::find($productId);
                    $quantity = $validated['quantities'][$index];

                    if ($product->stok < $quantity) {
                        throw new \Exception('Stok untuk produk "' . $product->barang->nama . '" tidak mencukupi. Stok tersedia: ' . $product->stok);
                    }

                    $subtotal = $product->harga_jual * $quantity;
                    $total += $subtotal;

                    $cartItemsForInsert[] = [
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'harga_satuan' => $product->harga_jual,
                        'subtotal' => $subtotal
                    ];
                }

                $sale = Sale::create([
                    'outlet_id' => $validated['outlet_id'],
                    'customer_name' => $validated['customer_name'],
                    'sale_date' => now(),
                    'total' => $total,
                    'created_by' => auth()->id(),
                ]);

                // Sekarang kita hanya perlu membuat SaleItem.
                // Pengurangan stok & mutasi stok akan diurus oleh TRIGGER di database.
                foreach ($cartItemsForInsert as $item) {
                    $sale->items()->create($item);
                }
            });

            return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            Log::error("Gagal menyimpan transaksi: " . $e->getMessage());
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Endpoint untuk JavaScript mengambil data produk berdasarkan outlet.
     */
    public function getProductsByOutlet(Request $request)
    {
        $products = Product::with('barang')
            ->where('outlet_id', $request->outlet_id)
            ->where('stok', '>', 0)
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        return response()->json($products);
    }

    public function show(Sale $penjualan)
    {
        // 'penjualan' adalah variabel yang otomatis diambil oleh Laravel berdasarkan ID di URL.
        // Kita gunakan 'load' untuk memuat relasi-relasi yang dibutuhkan.
        $penjualan->load(['outlet', 'creator', 'items.product.barang']);

        return view('layouts.admin', [
            'slot' => view('penjualan.show', ['sale' => $penjualan]),
            'title' => 'Detail Transaksi ' . 'TRX-' . str_pad($penjualan->id, 5, '0', STR_PAD_LEFT),
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }
}