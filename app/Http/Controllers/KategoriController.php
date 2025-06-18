<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Lembaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return view('produk-stok.kategori.index');
        }
        return view('layouts.admin', [
            'slot' => view('produk-stok.kategori.index'),
            'title' => 'Manajemen Kategori',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    public function getData(Request $request)
    {
        $query = Kategori::query();
        
        $lembaga_id = session('current_lembaga_id');
        $query = Kategori::where('lembaga_id', $lembaga_id); 
        
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
        }

        // Assign order column and direction from request, with defaults
        $orderCol = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');
        // Map column index to actual column name
        $columns = [
            0 => 'nama',
            1 => 'deskripsi',
        ];
        $orderCol = $columns[$orderCol] ?? 'nama';

        $query->orderBy($orderCol, $orderDir);

        $totalFiltered = $query->count();
        $data = $query->latest()->offset($request->start)->limit($request->length)->get();

        $jsonData = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => Kategori::count(),
            "recordsFiltered" => $totalFiltered,
            "data" => []
        ];

        foreach ($data as $kategori) {
            $editUrl = route('produk-stok.kategori.edit', $kategori->id);
            $deleteUrl = route('produk-stok.kategori.destroy', $kategori->id);

            ob_start(); ?>
            <div class="flex space-x-2">
                <a href="<?= $editUrl ?>" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700 transition edit-link">Edit</a>
                <button type="button" class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700 transition delete-btn" data-id="<?= $kategori->id ?>" data-url="<?= $deleteUrl ?>">Hapus</button>
            </div>
            <?php
            $actionButtons = ob_get_clean();

            $jsonData['data'][] = [
            $kategori->nama,
            $kategori->deskripsi ?? '-',
            $actionButtons
            ];
        }

        return response()->json($jsonData);
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            return view('produk-stok.kategori.create');
        }
        return view('layouts.admin', [
            'slot' => view('produk-stok.kategori.create'),
            'title' => 'Tambah Kategori Baru',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:kategori,nama',
            'deskripsi' => 'nullable|string',
            
        ]);
        $validated['lembaga_id'] = session('current_lembaga_id'); 

        Kategori::create($validated);

        return response()->json(['success' => true, 'message' => 'Kategori berhasil dibuat!', 'redirect' => route('produk-stok.kategori.index')]);
    }

    public function edit(Request $request, Kategori $kategori)
    {
        if ($request->ajax()) {
            return view('produk-stok.kategori.edit', compact('kategori'));
        }
        return view('layouts.admin', [
            'slot' => view('produk-stok.kategori.edit', compact('kategori')),
            'title' => 'Edit Kategori',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:kategori,nama,'.$kategori->id,
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($validated);
        
        return response()->json(['success' => true, 'message' => 'Kategori berhasil diperbarui!', 'redirect' => route('produk-stok.kategori.index')]);
    }

    public function destroy(Kategori $kategori)
    {
        try {
            $kategori->delete();
            return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus.']);
        } catch (\Exception $e) {
            Log::error('Gagal menghapus kategori: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus. Kategori ini mungkin sedang digunakan oleh produk.'], 500);
        }
    }
}