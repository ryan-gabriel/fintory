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
    public function index()
    {
        $sales = Sale::with('outlet')->latest()->paginate(15);
        return view('layouts.admin', [
            'slot' => view('penjualan.index', compact('sales')),
            'title' => 'Riwayat Penjualan',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    public function create()
    {
        $lembaga_id = session('current_lembaga_id');
        $data = [
            'outlets' => Outlet::where('lembaga_id', $lembaga_id)->orderBy('name')->get(),
        ];
        return view('layouts.admin', [
            'slot' => view('penjualan.create', $data),
            'title' => 'Buat Transaksi Penjualan',
            'lembaga' => Lembaga::find($lembaga_id),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'outlet_id' => 'required|exists:outlet,id',
            'customer_name' => 'required|string|max:100',
            'products' => 'required|array|min:1',
            'products.*' => 'required|exists:product,id',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
        ], [
            'products.required' => 'Keranjang belanja tidak boleh kosong.'
        ]);

        try {
            DB::transaction(function () use ($validated, $request) {
                $total = 0;
                $cart = [];

                foreach ($validated['products'] as $index => $productId) {
                    $product = Product::with('barang')->find($productId);
                    $quantity = $validated['quantities'][$index];
                    
                    if ($product->stok < $quantity) {
                        throw new \Exception('Stok untuk produk "' . $product->barang->nama . '" tidak mencukupi. Stok tersedia: ' . $product->stok);
                    }

                    $subtotal = $product->harga_jual * $quantity;
                    $total += $subtotal;
                    
                    $cart[] = ['product' => $product, 'quantity' => $quantity, 'subtotal' => $subtotal];
                }

                $sale = Sale::create([
                    'outlet_id' => $validated['outlet_id'],
                    'customer_name' => $validated['customer_name'],
                    'sale_date' => now(),
                    'total' => $total,
                    'created_by' => auth()->id(),
                ]);

                foreach ($cart as $item) {
                    SaleItem::create(['sale_id' => $sale->id, 'product_id' => $item['product']->id, 'quantity' => $item['quantity'], 'harga_satuan' => $item['product']->harga_jual, 'subtotal' => $item['subtotal']]);
                    $item['product']->decrement('stok', $item['quantity']);
                    StockMutation::create(['product_id' => $item['product']->id, 'outlet_id' => $validated['outlet_id'], 'quantity' => $item['quantity'], 'type' => 'out', 'reference_type' => 'sale', 'reference_id' => $sale->id]);
                }
            });
            return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error("Gagal menyimpan transaksi: " . $e->getMessage());
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function getProductsByOutlet(Request $request)
    {
        $products = Product::with('barang')
            ->where('outlet_id', $request->outlet_id)
            ->where('stok', '>', 0)->where('is_active', true)
            ->orderBy('id')->get();
        return response()->json($products);
    }
}