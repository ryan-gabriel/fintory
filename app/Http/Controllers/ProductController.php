<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Lembaga;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\StockMutation;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return view('produk-stok.produk.index');
        }

        return view('layouts.admin', [
            'slot' => view('produk-stok.produk.index'),
            'title' => 'Manajemen Produk',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    public function getData(Request $request)
    {
        // Gunakan 'with' untuk eager loading agar query lebih efisien
        $query = Product::with(['barang', 'kategori', 'outlet']);

        // Filter search
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->orWhereHas('barang', function ($q2) use ($search) {
                    $q2->where('nama', 'like', "%{$search}%");
                })->orWhereHas('kategori', function ($q2) use ($search) {
                    $q2->where('nama', 'like', "%{$search}%");
                })->orWhereHas('outlet', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Filter berdasarkan outlet yang aktif
        $activeOutletId = session('selected_outlet_id');
        if ($activeOutletId && $activeOutletId !== 'all') {
            $query->where('outlet_id', $activeOutletId);
        }

        // Ambil kolom dan arah pengurutan dari request, gunakan default jika tidak ada
        $orderCol = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir', 'asc');

        // Map kolom index ke nama kolom database
        $columns = [
            0 => 'barang_id',
            1 => 'kategori_id',
            2 => 'outlet_id',
            3 => 'harga_jual',
            4 => 'stok',
        ];
        $orderCol = isset($columns[$orderCol]) ? $columns[$orderCol] : 'id';

        if ($orderCol === 'outlet_id') {
            $query->join('outlets', 'outlets.id', '=', 'products.outlet_id')
                ->orderBy('outlets.name', $orderDir)
                ->select('products.*'); // ensure products.* is selected after join
        } else {
            $query->orderBy($orderCol, $orderDir);
        }


        $totalFiltered = $query->count();
        $data = $query->latest()->offset($request->start)->limit($request->length)->get();

        $jsonData = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => Product::count(),
            "recordsFiltered" => $totalFiltered,
            "data" => []
        ];

        foreach ($data as $product) {
            $jsonData['data'][] = [
                $product->barang->nama ?? 'N/A',
                $product->kategori->nama ?? 'N/A',
                $product->outlet->name ?? 'N/A',
                'Rp ' . number_format($product->harga_jual, 0, ',', '.'),
                $product->stok,
                '<div class="text-center">' .
                '<a href="' . route('produk-stok.produk.edit', $product->id) . '" class="edit-link inline-block px-3 py-1 bg-blue-500 text-white rounded font-semibold hover:bg-blue-600 transition">Edit</a> ' .
                '<a href="' . route('produk-stok.produk.destroy', $product->id) . '" class="delete-link inline-block px-3 py-1 bg-red-500 text-white rounded font-semibold hover:bg-red-600 transition" data-id="' . $product->id . '">Hapus</a>' .
                '</div>'
            ];
        }

        return response()->json($jsonData);
    }

    public function create(Request $request)
    {
        $data = [
            'barangs' => Barang::orderBy('nama')->get(),
            'kategoris' => Kategori::orderBy('nama')->get(),
            'outlets' => Outlet::where('lembaga_id', session('current_lembaga_id'))->orderBy('name')->get(),
        ];

        if ($request->ajax()) {
            return view('produk-stok.produk.create', $data);
        }
        return view('layouts.admin', [
            'slot' => view('produk-stok.produk.create', $data),
            'title' => 'Tambah Produk Baru',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barang,kode_barang',
            'kategori_id' => 'required|exists:kategori,id',
            'outlet_id' => 'required|exists:outlet,id',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        Product::create($validated + ['is_active' => true]);

        return response()->json(['success' => true, 'message' => 'Produk berhasil dibuat!', 'redirect' => route('produk-stok.produk.index')]);
    }

    public function edit(Request $request, Product $produk)
    {
        $data = [
            'produk' => $produk,
            'barangs' => Barang::orderBy('nama')->get(),
            'kategoris' => Kategori::orderBy('nama')->get(),
            'outlets' => Outlet::where('lembaga_id', session('current_lembaga_id'))->orderBy('name')->get(),
        ];

        if ($request->ajax()) {
            return view('produk-stok.produk.edit', $data);
        }
        return view('layouts.admin', [
            'slot' => view('produk-stok.produk.edit', $data),
            'title' => 'Edit Produk',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    public function update(Request $request, Product $produk)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barang,kode_barang',
            'kategori_id' => 'required|exists:kategori,id',
            'outlet_id' => 'required|exists:outlet,id',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        try {
            DB::transaction(function () use ($validated, $produk) {
                $stok_lama = $produk->stok;
                $stok_baru = (int) $validated['stok'];

                $produk->update($validated);

                if ($stok_baru != $stok_lama) {
                    $selisih = abs($stok_baru - $stok_lama);
                    $tipe_mutasi = ($stok_baru > $stok_lama) ? 'in' : 'out';

                    StockMutation::create([
                        'product_id' => $produk->id,
                        'outlet_id' => $produk->outlet_id,
                        'quantity' => $selisih,
                        'type' => $tipe_mutasi,
                        'reference_type' => 'adjustment',
                        'reference_id' => null,
                    ]);
                }
            });

            // ▼▼▼ GANTI BAGIAN INI ▼▼▼
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui!',
                'redirect' => route('produk-stok.produk.index')
            ]);
            // ▲▲▲ AKHIR PERUBAHAN ▲▲▲

        } catch (\Exception $e) {
            Log::error('Gagal update produk: ' . $e->getMessage());
            // Kirim respon error sebagai JSON juga
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui produk.'], 500);
        }
    }

    public function destroy(Product $produk)
    {
        try {
            $produk->delete();
            return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus.']);
        } catch (\Exception $e) {
            Log::error('Gagal menghapus produk: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus produk.'], 500);
        }
    }
}