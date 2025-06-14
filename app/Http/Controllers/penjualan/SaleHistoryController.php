<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleHistoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return view('penjualan.riwayat.index');
        }
        return view('layouts.admin', [
            'slot' => view('penjualan.riwayat.index'),
            'title' => 'Riwayat Penjualan',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    public function getData(Request $request)
    {
        $query = Sale::with('outlet');
        // ... Logika filter dan search bisa ditambahkan di sini ...

        $totalFiltered = $query->count();
        $data = $query->latest()->offset($request->start)->limit($request->length)->get();

        $jsonData = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => Sale::count(),
            "recordsFiltered" => $totalFiltered,
            "data" => []
        ];

        foreach($data as $sale) {
            $jsonData['data'][] = [
                $sale->sale_date,
                'TRX-' . str_pad($sale->id, 5, '0', STR_PAD_LEFT),
                $sale->outlet->name ?? 'N/A',
                $sale->customer_name,
                'Rp ' . number_format($sale->total, 0, ',', '.'),
                // '<a href="#" class="text-blue-500">Detail</a>'
            ];
        }

        return response()->json($jsonData);
    }
}