<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Lembaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BarangController extends Controller
{
    /**
     * Menampilkan halaman utama manajemen barang.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return view('produk-stok.barang.index');
        }
        return view('layouts.admin', [
            'slot' => view('produk-stok.barang.index'),
            'title' => 'Manajemen Barang',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    /**
     * Menyediakan data untuk DataTables.
     */
    public function getData(Request $request)
    {
        $query = Barang::query();
        
        // Filter pencarian
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
        }

        $totalFiltered = $query->count();
        $data = $query->latest()->offset($request->start)->limit($request->length)->get();

        // Siapkan format JSON yang benar untuk DataTables
        $jsonData = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => Barang::count(),
            "recordsFiltered" => $totalFiltered,
            "data" => [] // Mulai dengan array data kosong
        ];

        // Looping data dan format menjadi array-of-arrays
        foreach ($data as $barang) {
            $jsonData['data'][] = [
                // Kolom 0: Nama
                $barang->nama,
                // Kolom 1: Deskripsi
                $barang->deskripsi ?? '-',
                // Kolom 2: Aksi
                '<a href="'.route('produk-stok.barang.edit', $barang->kode_barang).'" class="edit-link text-yellow-500 font-semibold hover:underline">Edit</a> | ' .
                '<a href="'.route('produk-stok.barang.destroy', $barang->kode_barang).'" class="delete-link text-red-500 font-semibold hover:underline" data-id="'.$barang->kode_barang.'">Hapus</a>'
            ];
        }

        return response()->json($jsonData);
    }

    /**
     * Menampilkan form untuk membuat barang baru.
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            return view('produk-stok.barang.create');
        }
        return view('layouts.admin', [
            'slot' => view('produk-stok.barang.create'),
            'title' => 'Tambah Barang Baru',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    /**
     * Menyimpan barang baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:barang,nama',
            'deskripsi' => 'nullable|string',
        ]);

        Barang::create($validated);

        return response()->json(['success' => true, 'message' => 'Barang berhasil dibuat!', 'redirect' => route('produk-stok.barang.index')]);
    }

    /**
     * Menampilkan form untuk mengedit barang.
     */
    public function edit(Request $request, Barang $barang)
    {
        if ($request->ajax()) {
            return view('produk-stok.barang.edit', compact('barang'));
        }
        return view('layouts.admin', [
            'slot' => view('produk-stok.barang.edit', compact('barang')),
            'title' => 'Edit Barang',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    /**
     * Memperbarui data barang di database.
     */
    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:barang,nama,'.$barang->kode_barang.',kode_barang',
            'deskripsi' => 'nullable|string',
        ]);

        $barang->update($validated);
        
        // ==========================================================
        // === PERBAIKAN DI SINI (menggunakan nama route yang benar) ===
        // ==========================================================
        return response()->json(['success' => true, 'message' => 'Barang berhasil diperbarui!', 'redirect' => route('produk-stok.barang.index')]);
    }

    /**
     * Menghapus barang dari database.
     */
    public function destroy(Barang $barang)
    {
        try {
            $barang->delete();
            return response()->json(['success' => true, 'message' => 'Barang berhasil dihapus.']);
        } catch (\Exception $e) {
            Log::error('Gagal menghapus barang: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus barang. Mungkin barang ini sedang digunakan di data produk.'], 500);
        }
    }
}