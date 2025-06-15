<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockMutation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Outlet;

class MutasiStokController extends Controller
{
    public function getData(Request $request)
    {
        $columns = [
            0 => 'created_at',
            1 => 'outlet.name',
            2 => 'product.nama', // Perhatikan: field ini tidak ada di model Product
            3 => 'type',
            4 => 'quantity',
        ];

        $query = StockMutation::with(['product.barang', 'product.kategori', 'product.outlet', 'outlet']);

        // Filter tanggal menggunakan created_at
        if ($request->filled('start_date')) {
            try {
                $startDate = Carbon::createFromFormat('m/d/Y', $request->start_date)->startOfDay();
                $query->where('created_at', '>=', $startDate);
            } catch (\Exception $e) {
                Log::warning('Invalid start_date format: ' . $request->start_date);
            }
        }

        if ($request->filled('end_date')) {
            try {
                $endDate = Carbon::createFromFormat('m/d/Y', $request->end_date)->endOfDay();
                $query->where('created_at', '<=', $endDate);
            } catch (\Exception $e) {
                Log::warning('Invalid end_date format: ' . $request->end_date);
            }
        }

        // Filter outlet
        if (session()->has('selected_outlet_id')) {
            $selectedOutletId = session('selected_outlet_id');
            if (!empty($selectedOutletId) && $selectedOutletId !== 'all') {
                $query->where('outlet_id', $selectedOutletId);
            }
        }

        // Hitung total data sebelum filter (untuk recordsTotal)
        $totalData = StockMutation::count();

        // Global Search
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('type', 'like', "%{$search}%")
                    ->orWhere('quantity', 'like', "%{$search}%")
                    ->orWhereRaw("DATE_FORMAT(created_at, '%d-%m-%Y') like ?", ["%{$search}%"])
                    ->orWhereHas('product', function ($p) use ($search) {
                        // Ganti 'nama' dengan field yang benar dari model Product
                        // Atau gunakan relasi barang untuk mengakses nama barang
                        $p->whereHas('barang', fn ($b) => $b->where('nama', 'like', "%{$search}%"))
                        ->orWhereHas('kategori', fn ($k) => $k->where('nama', 'like', "%{$search}%"))
                        ->orWhereHas('outlet', fn ($o) => $o->where('name', 'like', "%{$search}%"));
                    })
                    ->orWhereHas('outlet', fn ($o) => $o->where('name', 'like', "%{$search}%"));
            });
        }

        // Hitung total data setelah filter (untuk recordsFiltered)
        $totalFiltered = $query->count();

        // Ordering
        $orderColIndex = $request->input('order.0.column', 0);
        $orderDir = strtolower($request->input('order.0.dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        
        // Handle ordering berdasarkan kolom
        switch ($orderColIndex) {
            case 0: // created_at
                $query->orderBy('created_at', $orderDir);
                break;
            case 1: // outlet name
                $query->join('outlet', 'stockmutation.outlet_id', '=', 'outlet.id')
                    ->orderBy('outlet.name', $orderDir)
                    ->select('stockmutation.*'); // Pastikan hanya select data stockmutation
                break;
            case 2: // product name (nama barang)
                $query->join('product', 'stockmutation.product_id', '=', 'product.id')
                    ->join('barang', 'product.barang_id', '=', 'barang.kode_barang')
                    ->orderBy('barang.nama', $orderDir)
                    ->select('stockmutation.*');
                break;
            case 3: // type
                $query->orderBy('type', $orderDir);
                break;
            case 4: // quantity
                $query->orderBy('quantity', $orderDir);
                break;
            default:
                $query->orderBy('created_at', $orderDir);
        }

        // Pagination
        $start = max(0, intval($request->input('start', 0)));
        $length = max(1, intval($request->input('length', 10)));

        $data = $query->skip($start)->take($length)->get();

        $jsonData = [
            "draw" => intval($request->input('draw', 1)),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data" => [],
        ];

        foreach ($data as $row) {
            $jsonData['data'][] = [
                $row->created_at ? $row->created_at->format('d-m-Y') : '-',
                $row->outlet->name ?? '-',
                // Gunakan nama barang dari relasi barang, bukan dari product
                $row->product->barang->nama ?? '-', 
                ucfirst($row->type ?? ''),
                $row->quantity ?? 0,

            ];
        }

        return response()->json($jsonData);
    }

    public function index(Request $request)
    {
        $outlets = Outlet::all();
        $selectedOutletId = session('selected_outlet_id', 'all');

        $selectedOutletName = $selectedOutletId === 'all'
            ? 'Semua Outlet'
            : optional($outlets->firstWhere('id', $selectedOutletId))->name ?? '-';

        $viewData = compact('outlets', 'selectedOutletId', 'selectedOutletName');

        if ($request->ajax()) {
            return view('laporan.mutasi-stok', $viewData);
        }

        return view('layouts.admin', [
            'slot' => view('laporan.mutasi-stok', $viewData),
            'title' => 'Mutasi Stok',
            'lembaga' => \App\Models\Lembaga::find(session('current_lembaga_id')),
        ]);
    }
}
