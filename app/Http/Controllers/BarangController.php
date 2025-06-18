<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Lembaga;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

        // filter ordering
        if ($request->filled('order')) {
            $columnIndex = $request->input('order.0.column');
            $direction = $request->input('order.0.dir', 'asc');
            $columns = ['nama', 'deskripsi']; // Sesuaikan dengan kolom yang ada
            if (isset($columns[$columnIndex])) {
                $query->orderBy($columns[$columnIndex], $direction);
            }
        }

        $totalFiltered = $query->count();
        $start = $request->input('start', 0);
        $length = $request->input('length', 10); // Default ke 10 jika tidak ada
        $data = $query->skip($start)->take($length)->get();

        // Siapkan format JSON yang benar untuk DataTables
        $jsonData = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => Barang::count(),
            "recordsFiltered" => $totalFiltered,
            "data" => [] // Mulai dengan array data kosong
        ];

        // Looping data dan format menjadi array-of-arrays
        foreach ($data as $barang) {
            $editUrl = route('produk-stok.barang.edit', $barang->kode_barang);
            $deleteUrl = route('produk-stok.barang.destroy', $barang->kode_barang);

            ob_start(); ?>
                <div class="flex space-x-2">
                    <a href="<?= $editUrl ?>" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700 transition edit-link">Edit</a>
                    <button type="button" class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700 transition delete-btn" data-id="<?= $barang->kode_barang ?>" data-url="<?= $deleteUrl ?>">Hapus</button>
                </div>
            <?php
            $actionButtons = ob_get_clean();

            $jsonData['data'][] = [
                $barang->nama ?? '-',
                $barang->deskripsi ?? '-',
                $actionButtons
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
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|string|max:100|unique:barang,nama,' . $barang->kode_barang . ',kode_barang',
                'deskripsi' => 'nullable|string',
            ],
            [
                'nama.required' => 'Nama barang wajib diisi.',
                'nama.max' => 'Nama barang maksimal 100 karakter.',
                'nama.unique' => 'Nama barang sudah digunakan, silakan gunakan nama lain.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $barang->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil diperbarui!',
            'redirect' => route('produk-stok.barang.index')
        ]);

        $barang->update($validated);

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