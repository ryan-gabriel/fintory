<?php

namespace App\Http\Controllers;

use App\Models\Lembaga;
use App\Models\Outlet;
use Illuminate\Http\Request;

class SaldoOutletController extends Controller
{
    /**
     * Menampilkan halaman utama Saldo Outlet.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return view('outlet_karyawan.saldo_outlet.index');
        }
        return view('layouts.admin', [
            'slot' => view('outlet_karyawan.saldo_outlet.index'),
            'title' => 'Saldo Outlet',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    /**
     * Menyediakan data untuk DataTables.
     */
    public function getData(Request $request)
    {
        $currentLembagaId = session('current_lembaga_id');
        
        // Mengambil outlet yang berelasi dengan lembaga saat ini
        // dan memuat relasi balance untuk setiap outlet
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
                // Mengambil saldo dari relasi dan memformatnya
                'Rp ' . number_format($outlet->balance->balance, 0, ',', '.')
            ];
        }

        return response()->json($jsonData);
    }
}