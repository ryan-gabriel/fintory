<?php

namespace App\Http\Controllers;

use App\Models\StockMutation;
use App\Models\Lembaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StockMutationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return view('produk-stok.mutasi.index');
        }

        return view('layouts.admin', [
            'slot' => view('produk-stok.mutasi.index'),
            'title' => 'Riwayat Mutasi Stok',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    public function getData(Request $request)
    {
        // Eager load relasi untuk efisiensi query
        $query = StockMutation::with(['product.barang', 'outlet']);

        // Filter pencarian
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function($q) use ($search) {
                $q->where('type', 'like', "%{$search}%")
                  ->orWhere('quantity', 'like', "%{$search}%")
                  ->orWhere('reference_type', 'like', "%{$search}%")
                  ->orWhereHas('product.barang', function ($q2) use ($search) {
                      $q2->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('outlet', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $totalFiltered = $query->count();
        $data = $query->latest()->offset($request->start)->limit($request->length)->get();

        $jsonData = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => StockMutation::count(),
            "recordsFiltered" => $totalFiltered,
            "data" => []
        ];

        foreach ($data as $mutation) {
            $quantity_class = $mutation->type === 'in' ? 'text-green-500' : 'text-red-500';
            $quantity_prefix = $mutation->type === 'in' ? '+' : '-';

            $jsonData['data'][] = [
                $mutation->created_at->format('d-m-Y H:i'),
                $mutation->product->barang->nama ?? 'Produk Dihapus',
                $mutation->outlet->name ?? 'Outlet Dihapus',
                ucfirst($mutation->type),
                '<span class="'.$quantity_class.' font-semibold">'.$quantity_prefix . $mutation->quantity.'</span>',
                ucfirst($mutation->reference_type)
            ];
        }

        return response()->json($jsonData);
    }
}