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
        // 1. Definisikan kolom untuk sorting
        $columns = [
            0 => 'sale_date',
            1 => 'id',
            2 => 'outlets.name',
            3 => 'customer_name',
            4 => 'total',
        ];

        // Memulai query dan langsung memanggil Stored Function
        $query = Sale::with(['outlet'])->select(
            'sale.*', // Ambil semua kolom dari tabel sale
            DB::raw('FormatSaleID(sale.id) as formatted_id')
        );

        $lembaga_id = session('current_lembaga_id');
        $query->whereHas('outlet', function ($q) use ($lembaga_id) {
            $q->where('lembaga_id', $lembaga_id);
        });

        // 2. Gunakan nama session yang konsisten
        $activeOutletId = session('active_outlet_id');
        if ($activeOutletId && $activeOutletId !== 'all') {
            $query->where('sale.outlet_id', $activeOutletId);
        }

        // Filter Tanggal dari Date Picker
        if ($request->filled('start_date') && $request->filled('end_date')) {
            try {
                $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->start_date)->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->end_date)->endOfDay();
                $query->whereBetween('sale_date', [$startDate, $endDate]);
            } catch (\Exception $e) {
                Log::warning('Invalid date format: ' . $request->start_date . ' or ' . $request->end_date);
            }
        }

        // Filter Pencarian Global dari DataTables
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhereHas('outlet', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $totalDataForLembaga = $query->clone()->count();
        $totalFiltered = $query->clone()->count();


        // Logika Pengurutan (Ordering)
        if ($request->filled('order')) {
            $order = $request->input('order')[0];
            $orderColIndex = $order['column'];
            $orderDir = $order['dir'];
            $orderColName = $columns[$orderColIndex] ?? 'sale_date';

            if ($orderColName === 'outlets.name') {
                $query->join('outlet', 'outlet.id', '=', 'sale.outlet_id')
                    ->orderBy('outlet.name', $orderDir);
            } else {
                $query->orderBy($orderColName, $orderDir);
            }
        } else {
            $query->latest('sale_date');
        }

        $data = $query->offset($request->start)->limit($request->length)->get();

        $jsonData = [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => Sale::whereHas('outlet', fn($q) => $q->where('lembaga_id', $lembaga_id))->count(),
            "recordsFiltered" => $totalFiltered,
            "data"            => []
        ];

        foreach ($data as $sale) {
            $jsonData['data'][] = [
                \Carbon\Carbon::parse($sale->sale_date)->format('d M Y'),
                $sale->formatted_id, // Sekarang ini akan ada nilainya
                $sale->outlet->name ?? 'N/A',
                $sale->customer_name,
                'Rp ' . number_format($sale->total, 0, ',', '.'),
                '<a href="'.route('penjualan.show', $sale->id).'" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Detail</a>'
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

        $outlets = Outlet::where('lembaga_id', $lembaga_id)
            ->whereHas('products', function ($query) {
                $query->where('is_active', true)->where('stok', '>', 0);
            })
            ->orderBy('name')
            ->get();

        $data = [
            'outlets' => $outlets,
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

                // 3. Cari atau buat baru record saldo untuk outlet ini
                $outletBalance = \App\Models\OutletBalance::firstOrNew(['outlet_id' => $sale->outlet_id]);

                // 4. Tambahkan saldo dengan total penjualan
                $outletBalance->saldo += $sale->total;
                $outletBalance->last_updated = now();

                // 5. Simpan perubahan saldo
                $outletBalance->save();
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