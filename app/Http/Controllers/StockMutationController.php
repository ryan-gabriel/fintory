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

        if ($request->filled('start_date')) {
            try {
            $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->start_date)->startOfDay();
            $query->where('created_at', '>=', $startDate);
            } catch (\Exception $e) {
            Log::warning('Invalid start_date format in Stock Mutation: ' . $request->start_date);
            }
        }

        if ($request->filled('end_date')) {
            try {
            $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->end_date)->endOfDay();
            $query->where('created_at', '<=', $endDate);
            } catch (\Exception $e) {
            Log::warning('Invalid end_date format in Stock Mutation: ' . $request->end_date);
            }
        }

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

        $activeOutletId = session('selected_outlet_id');
        if ($activeOutletId && $activeOutletId !== 'all') {
            $query->where('outlet_id', $activeOutletId);
        }


        // Ambil parameter sorting dari request
        $orderCol = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir', 'asc');
        $columns = [
            0 => 'created_at',
            1 => 'product_id',
            2 => 'outlet_id',
            3 => 'type',
            4 => 'quantity',
            5 => 'reference_type'
        ];
        $orderCol = isset($columns[$orderCol]) ? $columns[$orderCol] : 'created_at';

        // Handle sorting by related column (e.g., outlet.name)
        if ($orderCol === 'outlet.name') {
            $query->join('outlets', 'outlets.id', '=', 'stock_mutations.outlet_id')
                ->orderBy('outlets.name', $orderDir)
                ->select('stock_mutations.*'); // ensure stock_mutations.* is selected after join
        } else {
            $query->orderBy($orderCol, $orderDir);
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
                $mutation->created_at->format('d-m-Y'),
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