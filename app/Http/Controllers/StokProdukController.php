<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StokProdukController extends Controller
{
    public function getData(Request $request)
    {
        $currentLembagaId = session('current_lembaga_id');

        // Ambil semua outlet_id milik lembaga ini
        $outletIds = \App\Models\Outlet::where('lembaga_id', $currentLembagaId)->pluck('id');

        // Query dasar + filter lembaga (via outlet_id)
        $query = Product::with(['barang', 'kategori', 'outlet'])
            ->whereIn('outlet_id', $outletIds);

        // Filter tanggal dibuat
        if ($request->filled('start_date')) {
            try {
                $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date)->startOfDay();
                $query->where('created_at', '>=', $startDate);
            } catch (\Exception $e) {
                Log::warning('Invalid start_date format: ' . $request->start_date);
            }
        }

        if ($request->filled('end_date')) {
            try {
                $endDate = Carbon::createFromFormat('d-m-Y', $request->end_date)->endOfDay();
                $query->where('created_at', '<=', $endDate);
            } catch (\Exception $e) {
                Log::warning('Invalid end_date format: ' . $request->end_date);
            }
        }

        // Filter outlet aktif jika dipilih
        if (session()->has('selected_outlet_id')) {
            $selectedOutletId = session('selected_outlet_id');
            if (!empty($selectedOutletId) && $selectedOutletId !== 'all') {
                $query->where('outlet_id', $selectedOutletId);
            }
        }

        // Total data sebelum filter
        $totalData = Product::whereIn('outlet_id', $outletIds)->count();

        // Global search
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('harga_jual', 'like', "%{$search}%")
                    ->orWhere('stok', 'like', "%{$search}%")
                    ->orWhereRaw("DATE_FORMAT(created_at, '%d-%m-%Y') like ?", ["%{$search}%"])
                    ->orWhereHas('barang', function ($b) use ($search) {
                        $b->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kategori', function ($k) use ($search) {
                        $k->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('outlet', function ($o) use ($search) {
                        $o->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Total data setelah filter
        $totalFiltered = $query->count();

        // Ordering - hanya untuk kolom langsung di tabel product
        $orderColIndex = $request->input('order.0.column', 0);
        $orderDir = strtolower($request->input('order.0.dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        $orderableColumns = [
            0 => 'created_at',
            4 => 'harga_jual', 
            5 => 'stok',
            6 => 'is_active'
        ];

        if (isset($orderableColumns[$orderColIndex])) {
            $query->orderBy($orderableColumns[$orderColIndex], $orderDir);
        } else {
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
                $row->barang->nama ?? '-',
                $row->kategori->nama ?? '-',
                $row->outlet->name ?? '-',
                'Rp ' . number_format($row->harga_jual ?? 0, 0, ',', '.'),
                number_format($row->stok ?? 0, 0, ',', '.'),
                $row->is_active ? 'Aktif' : 'Nonaktif',
                '<a href="' . route('laporan.stok.produk.show', $row->id) . '" class="text-indigo-600 hover:underline font-medium menu-link">Detail</a>'
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
            return view('laporan.produk', $viewData);
        }

        return view('layouts.admin', [
            'slot' => view('laporan.produk', $viewData),
            'title' => 'Laporan Produk',
            'lembaga' => \App\Models\Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    public function show(Request $request, $id)
    {
        $mutation = \App\Models\StockMutation::with([
            'product.barang', 
            'product.kategori', 
            'product.outlet', 
            'outlet'
        ])->findOrFail($id);

        $viewData = compact('mutation');

        if ($request->ajax()) {
            return view('laporan.produk-detail', $viewData);
        }

        return view('layouts.admin', [
            'slot' => view('laporan.produk-detail', $viewData),
            'title' => 'Detail Mutasi Stok',
            'lembaga' => \App\Models\Lembaga::find(session('current_lembaga_id')),
        ]);
    }

}