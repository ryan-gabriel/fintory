<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Lembaga;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            $query->where(function($q) use ($search) {
                $q->orWhereHas('barang', function ($q2) use ($search) {
                    $q2->where('nama', 'like', "%{$search}%");
                })->orWhereHas('kategori', function ($q2) use ($search) {
                    $q2->where('nama', 'like', "%{$search}%");
                })->orWhereHas('outlet', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
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
                    '<a href="'.route('produk-stok.produk.edit', $product->id).'" class="edit-link text-yellow-500 font-semibold hover:underline">Edit</a> | ' .
                    '<a href="'.route('produk-stok.produk.destroy', $product->id).'" class="delete-link text-red-500 font-semibold hover:underline" data-id="'.$product->id.'">Hapus</a>' .
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

        $produk->update($validated);

        return response()->json(['success' => true, 'message' => 'Produk berhasil diperbarui!', 'redirect' => route('produk-stok.produk.index')]);
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