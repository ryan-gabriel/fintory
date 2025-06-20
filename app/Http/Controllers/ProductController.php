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
        $lembaga_id = session('current_lembaga_id');

        $query = Product::with(['barang', 'kategori', 'outlet'])
            ->whereHas('outlet', function ($query) use ($lembaga_id) {
                $query->where('lembaga_id', $lembaga_id);
            });

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
        $orderColIndex = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir', 'asc');

        // Map kolom index ke nama kolom database
        $columns = [
            0 => 'barang.nama',
            1 => 'kategori.nama',
            2 => 'outlet.name',
            3 => 'harga_jual',
            4 => 'stok',
        ];
        $orderColName = $columns[$orderColIndex] ?? 'product.id';

        // Lakukan join jika sorting berdasarkan nama dari tabel relasi
        if ($orderColIndex == 0) { // NAMA BARANG
            $query->join('barang', 'product.barang_id', '=', 'barang.kode_barang')
                  ->orderBy('barang.nama', $orderDir)
                  ->select('product.*'); 
        } elseif ($orderColIndex == 1) { // KATEGORI
            $query->join('kategori', 'product.kategori_id', '=', 'kategori.id')
                  ->orderBy('kategori.nama', $orderDir)
                  ->select('product.*');
        } elseif ($orderColIndex == 2) { // OUTLET
            $query->join('outlet', 'product.outlet_id', '=', 'outlet.id')
                ->orderBy('outlet.name', $orderDir)
                ->select('product.*');
        } else {
            $query->orderBy($orderColName, $orderDir);
        }

        $totalFiltered = (clone $query)->count();
        $data = $query->offset($request->start)->limit($request->length)->get();

        $jsonData = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => Product::whereHas('outlet', function($q) use ($lembaga_id) { $q->where('lembaga_id', $lembaga_id); })->count(),
            "recordsFiltered" => $totalFiltered,
            "data" => []
        ];

        foreach ($data as $product) {
            $editUrl = route('produk-stok.produk.edit', $product->id);
            $toggleStatusUrl = $product->is_active
                ? route('produk-stok.produk.non-active')
                : route('produk-stok.produk.active');

            $toggleLabel = $product->is_active ? 'Nonaktifkan' : 'Aktifkan';
            $toggleColor = $product->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700';
            $dataAction = $product->is_active ? 'non-active' : 'active';

            ob_start(); ?>
            <div class="flex space-x-2">
                <a href="<?= $editUrl ?>"
                    class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700 transition edit-link">Edit</a>

                <button type="button"
                    class="px-3 py-1 <?= $toggleColor ?> text-white rounded text-sm transition toggle-status-product-btn"
                    data-id="<?= $product->id ?>" data-url="<?= $toggleStatusUrl ?>" data-action=<?= $dataAction ?>>
                    <?= $toggleLabel ?>
                </button>
            </div>
            <?php
            $actionButtons = ob_get_clean();

            $jsonData['data'][] = [
                $product->barang->nama ?? 'N/A',
                optional($product->kategori)->nama ?? 'N/A',
                $product->outlet->name ?? 'N/A',
                'Rp ' . number_format($product->harga_jual ?? 0, 0, ',', '.'),
                $product->stok ?? 0,
                $actionButtons
            ];
        }


        return response()->json($jsonData);
    }

    public function create(Request $request)
    {
        $lembaga_id = session('current_lembaga_id');
        $data = [
            'barangs' => Barang::where('lembaga_id', $lembaga_id)->orderBy('nama')->get(),
            'kategoris' => Kategori::where('lembaga_id', $lembaga_id)->orderBy('nama')->get(),
            'outlets' => Outlet::where('lembaga_id', $lembaga_id)->orderBy('name')->get(),
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
        $lembaga_id = session('current_lembaga_id');
        $data = [
            'produk' => $produk,
            'barangs' => Barang::where('lembaga_id', $lembaga_id)->orderBy('nama')->get(),
            'kategoris' => Kategori::where('lembaga_id', $lembaga_id)->orderBy('nama')->get(),
            'outlets' => Outlet::where('lembaga_id', $lembaga_id)->orderBy('name')->get(),
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

                    // Siapkan data untuk dimasukkan ke stockmutation
                    $data_mutasi = [
                        'product_id' => $produk->id,
                        'outlet_id' => $produk->outlet_id,
                        'quantity' => $selisih,
                        'type' => $tipe_mutasi,
                        'reference_type' => 'adjustment',
                        'reference_id' => null,
                        'created_at' => now(),
                    ];

                    // Simpan mutasi stok
                    StockMutation::create($data_mutasi);

                    

                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui!',
                'redirect' => route('produk-stok.produk.index')
            ]);


        } catch (\Exception $e) {
            Log::error('Gagal update produk: ' . $e->getMessage());
            // Kirim respon error sebagai JSON juga
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui produk.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $produk = Product::findOrFail($id);
            $produk->delete();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal menghapus produk: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus produk. ' . $e->getMessage()
            ], 500);
        }
    }

    public function nonActive(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:product,id',
        ]);

        try {
            $product = Product::findOrFail($request->id);
            $product->is_active = false;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dinonaktifkan.',
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal nonaktifkan produk: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menonaktifkan produk.',
            ], 500);
        }
    }

    public function active(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:product,id',
        ]);

        try {
            $product = Product::findOrFail($request->id);
            $product->is_active = true;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diaktifkan kembali.',
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal aktifkan produk: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengaktifkan produk.',
            ], 500);
        }
    }
}
