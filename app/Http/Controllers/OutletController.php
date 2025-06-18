<?php

namespace App\Http\Controllers;

use App\Models\Lembaga;
use App\Models\Outlet;
use App\Models\OutletBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{
    /**
     * Menampilkan halaman utama manajemen outlet (Daftar Outlet).
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return view('outlet.index');
        }
        return view('layouts.admin', [
            'slot' => view('outlet.index'),
            'title' => 'Manajemen Outlet',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
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

        $totalFiltered = (clone $query)->count();

        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = $request->input('order.0.dir', 'asc');
        
        $columns = [
            0 => 'name',
            1 => 'address',
            2 => 'phone'
        ];
        
        $orderColumnName = $columns[$orderColumnIndex] ?? 'name';
        $query->orderBy($orderColumnName, $orderDirection);

        $data = $query->offset($request->start)->limit($request->length)->get();

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
        
        // Query dasar dengan JOIN ke tabel outletbalance
        $query = Outlet::where('outlet.lembaga_id', $currentLembagaId)
                       ->join('outletbalance', 'outlet.id', '=', 'outletbalance.outlet_id');

        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('outlet.name', 'like', "%{$search}%");
            });
        }
        
        $totalFiltered = (clone $query)->count();

        // Logika sorting dinamis untuk semua kolom
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDirection = $request->input('order.0.dir', 'asc');
        
        $columns = [
            0 => 'outlet.name',
            1 => 'outletbalance.saldo',
            2 => 'outletbalance.last_updated'
        ];
        
        $orderColumnName = $columns[$orderColumnIndex] ?? 'outlet.name';
        $query->orderBy($orderColumnName, $orderDirection);

        // Pilih kolom secara eksplisit untuk menghindari ambiguitas
        $data = $query->select('outlet.*', 'outletbalance.saldo', 'outletbalance.last_updated')
                      ->offset($request->start)
                      ->limit($request->length)
                      ->get();

        $jsonData = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => Outlet::where('lembaga_id', $currentLembagaId)->count(),
            "recordsFiltered" => $totalFiltered,
            "data" => []
        ];

        foreach ($data as $outlet) {
            $jsonData['data'][] = [
                $outlet->name,
                'Rp ' . number_format($outlet->saldo ?? 0, 0, ',', '.'),
                $outlet->last_updated ? Carbon::parse($outlet->last_updated)->format('d F Y, H:i') : 'N/A'
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
            // Gunakan transaksi DB agar jika salah satu gagal, rollback semuanya
            DB::beginTransaction();

            // Simpan outlet baru
            $outlet = Outlet::create($validated);

            // Buat saldo awal outlet balance
            OutletBalance::create([
                'outlet_id' => $outlet->id,
                'saldo' => 0,
                'last_updated' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Outlet berhasil ditambahkan!',
                'redirect' => route('outlet.index'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal membuat outlet: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data ke database.'
            ], 500);
        }
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

        if ($hasRelasi && !$force) {
            return response()->json([
                'requiresConfirmation' => true,
                'message' => 'Outlet memiliki data terkait (produk, penjualan, dll). Apakah Anda yakin ingin menghapus semua?'
            ]);
        }

        try {
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
