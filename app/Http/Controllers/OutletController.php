<?php

namespace App\Http\Controllers;

use App\Models\Lembaga;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class OutletController extends Controller
{
    /**
     * Menampilkan halaman utama manajemen outlet (Daftar Outlet).
     */
    public function index(Request $request)
    {
        $currentLembagaId = session('current_lembaga_id');
        if (!$currentLembagaId) {
            return redirect()->route('dashboard')->with('error', 'Sesi lembaga tidak valid. Silakan pilih lembaga kembali.');
        }
        $lembaga = Lembaga::find($currentLembagaId);
        if (!$lembaga) {
            return redirect()->route('dashboard')->with('error', 'Lembaga tidak ditemukan. Silakan login ulang.');
        }

        if ($request->ajax()) {
            return view('outlet.index');
        }
        return view('layouts.admin', [
            'slot' => view('outlet.index'),
            'title' => 'Manajemen Outlet',
            'lembaga' => $lembaga,
        ]);
    }

    /**
     * Menyediakan data untuk DataTable halaman Daftar Outlet.
     */
    public function getData(Request $request)
    {
        $currentLembagaId = session('current_lembaga_id');
        $query = Outlet::where('lembaga_id', $currentLembagaId);

        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $totalFiltered = $query->count();
        $data = $query->latest()->offset($request->start)->limit($request->length)->get();

        $jsonData = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => Outlet::where('lembaga_id', $currentLembagaId)->count(),
            "recordsFiltered" => $totalFiltered,
            "data" => []
        ];

        foreach ($data as $outlet) {
            $editUrl = route('outlet.edit', $outlet->id);
            $deleteUrl = route('outlet.destroy', $outlet->id);

            $actionButtons = '
                <div class="flex space-x-2 justify-center">
                    <a href="' . $editUrl . '" class="edit-link px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700 transition">Edit</a>
                    <a href="#" class="delete-btn delete-outlet px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700 transition" data-url="' . $deleteUrl . '">Delete</a>
                </div>
            ';

            $jsonData['data'][] = [
                $outlet->name,
                $outlet->address,
                $outlet->phone,
                $actionButtons
            ];
        }
        return response()->json($jsonData);
    }

    /**
     * Menampilkan halaman Saldo Outlet.
     */
    public function saldoIndex(Request $request)
    {
        $currentLembagaId = session('current_lembaga_id');
        if (!$currentLembagaId) {
            return redirect()->route('dashboard')->with('error', 'Sesi lembaga tidak valid. Silakan pilih lembaga kembali.');
        }

        $lembaga = Lembaga::find($currentLembagaId);
        if (!$lembaga) {
            return redirect()->route('dashboard')->with('error', 'Lembaga tidak ditemukan. Silakan login ulang.');
        }
        
        if ($request->ajax()) {
            return view('outlet_karyawan.saldo_outlet.index');
        }
        return view('layouts.admin', [
            'slot' => view('outlet_karyawan.saldo_outlet.index'),
            'title' => 'Saldo Outlet',
            'lembaga' => $lembaga,
        ]);
    }

    /**
     * Menyediakan data untuk DataTable halaman Saldo Outlet.
     */
    public function getSaldoData(Request $request)
    {
        $currentLembagaId = session('current_lembaga_id');
        $query = Outlet::where('lembaga_id', $currentLembagaId)->with('balance');

        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
        }

        $totalFiltered = $query->count();
        $data = $query->latest()->offset($request->start)->limit($request->length)->get();

        $jsonData = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => Outlet::where('lembaga_id', $currentLembagaId)->count(),
            "recordsFiltered" => $totalFiltered,
            "data" => []
        ];

        foreach ($data as $outlet) {
            $jsonData['data'][] = [
                $outlet->name,
                $outlet->address,
                // 2. Mengambil nilai 'balance' dari relasi yang sudah dimuat
                //    dan memformatnya sebagai mata uang Rupiah.
                'Rp ' . number_format($outlet->balance->balance, 0, ',', '.')
            ];
        }

        return response()->json($jsonData);
    }
    
    /**
     * Menampilkan form untuk membuat outlet baru.
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            return view('outlet.create');
        }
        return view('layouts.admin', [
            'slot' => view('outlet.create'),
            'title' => 'Tambah Outlet Baru',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    /**
     * Menyimpan outlet baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        $currentLembagaId = session('current_lembaga_id');
        if (!$currentLembagaId) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi lembaga tidak ditemukan. Silakan login ulang.'
            ], 400);
        }
        $validated['lembaga_id'] = $currentLembagaId;

        try {
            Outlet::create($validated);
        } catch (\Exception $e) {
            Log::error("Gagal membuat outlet: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data ke database.'
            ], 500);
        }

        return response()->json([
            'success' => true, 
            'message' => 'Outlet berhasil ditambahkan!', 
            'redirect' => route('outlet.index')
        ]);
    }
    
    /**
     * Menampilkan form untuk mengedit outlet.
     */
    public function edit(Request $request, Outlet $outlet)
    {
        if ($outlet->lembaga_id != session('current_lembaga_id')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax()) {
            return view('outlet.edit', compact('outlet'));
        }
        
        return view('layouts.admin', [
            'slot' => view('outlet.edit', compact('outlet')),
            'title' => 'Edit Outlet',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    /**
     * Memperbarui data outlet di database.
     */
    public function update(Request $request, Outlet $outlet)
    {
        if ($outlet->lembaga_id != session('current_lembaga_id')) {
            return response()->json(['success' => false, 'message' => 'Aksi tidak diizinkan.'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        $outlet->update($validated);

        return response()->json([
            'success' => true, 
            'message' => 'Outlet berhasil diperbarui!', 
            'redirect' => route('outlet.index')
        ]);
    }
    
    /**
     * Menghapus outlet dari database.
     */
    public function destroy(Request $request, $outlet_id)
    {
        $outlet = Outlet::findOrFail($outlet_id);

        if ($outlet->lembaga_id != session('current_lembaga_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Aksi tidak diizinkan.'
            ], 403);
        }

        $force = $request->input('force', false);

        $hasRelasi = $outlet->products()->exists()
            || $outlet->sales()->exists()
            || $outlet->stockMutations()->exists()
            || $outlet->hutang()->exists()
            || $outlet->employees()->exists()
            || $outlet->cashLedgers()->exists();

        // Jika ada relasi dan belum dikonfirmasi untuk force delete
        if ($hasRelasi && !$force) {
            return response()->json([
                'requiresConfirmation' => true,
                'message' => 'Outlet memiliki data terkait (produk, penjualan, dll). Apakah Anda yakin ingin menghapus semua?'
            ]);
        }

        try {
            // Jika force, hapus relasi dulu (opsional)
            if ($force) {
                $outlet->products()->delete();
                $outlet->sales()->delete();
                $outlet->stockMutations()->delete();
                $outlet->hutang()->delete();
                $outlet->employees()->delete();
                $outlet->cashLedgers()->delete();
            }

            $outlet->delete();

            return response()->json([
                'success' => true,
                'message' => 'Outlet berhasil dihapus.'
            ]);
        } catch (QueryException $e) {
            Log::error('Gagal menghapus outlet: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus outlet karena kesalahan database.'
            ], 500);
        }
    }

}