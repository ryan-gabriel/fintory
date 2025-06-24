<?php

namespace App\Http\Controllers;

use App\Models\Lembaga;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; // 1. Import facade Cache

class SaldoOutletController extends Controller
{
    /**
     * Menampilkan halaman utama Saldo Outlet.
     */
    public function index(Request $request)
    {
        // Data lembaga jarang berubah, bisa juga di-cache
        $lembaga = Cache::remember('lembaga:' . session('current_lembaga_id'), now()->addHours(24), function () {
            return Lembaga::find(session('current_lembaga_id'));
        });

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
     * Menyediakan data untuk DataTables dengan implementasi caching.
     */
    public function getData(Request $request)
    {
        $currentLembagaId = session('current_lembaga_id');
        $search = $request->input('search.value', '');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw = intval($request->input('draw'));

        // 2. Tentukan tag untuk cache ini agar mudah di-flush nanti
        $cacheTag = 'saldo_outlet';

        // 3. Buat kunci cache yang unik berdasarkan semua parameter yang relevan
        $cacheKey = "saldo_outlet:lembaga:{$currentLembagaId}:search:{$search}:start:{$start}:length:{$length}";

        // 4. Gunakan Cache::tags()->remember() untuk mendapatkan atau menyimpan data
        // Data akan disimpan selama 10 menit. Sesuaikan durasi sesuai kebutuhan.
        $jsonData = Cache::tags($cacheTag)->remember($cacheKey, now()->addMinutes(10), function () use ($currentLembagaId, $request, $search, $start, $length) {

            // --- SEMUA LOGIKA ASLI MASUK KE DALAM CLOSURE INI ---

            $query = Outlet::where('lembaga_id', $currentLembagaId)->with('balance');

            // Terapkan pencarian jika ada
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%");
                });
            }

            $totalFiltered = $query->count();
            $data = $query->latest()->offset($start)->limit($length)->get();

            $formattedData = [];
            foreach ($data as $outlet) {
                $formattedData[] = [
                    $outlet->name,
                    $outlet->address,
                    'Rp ' . number_format($outlet->balance->balance ?? 0, 0, ',', '.')
                ];
            }

            return [
                "recordsTotal" => Outlet::where('lembaga_id', $currentLembagaId)->count(),
                "recordsFiltered" => $totalFiltered,
                "data" => $formattedData
            ];
            // --- AKHIR DARI LOGIKA ASLI ---
        });

        // 5. Tambahkan 'draw' ke data yang diambil dari cache atau yang baru dibuat
        // 'draw' tidak di-cache karena nilainya selalu berubah di setiap request DataTables
        $jsonData['draw'] = $draw;

        return response()->json($jsonData);
    }
}