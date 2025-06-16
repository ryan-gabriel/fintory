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
            2 => 'product.nama', // dari relasi barang
            3 => 'type',
            4 => 'quantity',
        ];

        $currentLembagaId = session('current_lembaga_id');

        // Ambil semua outlet_id milik lembaga aktif
        $outletIds = \App\Models\Outlet::where('lembaga_id', $currentLembagaId)->pluck('id');

        // Filter awal berdasarkan outlet lembaga
        $query = StockMutation::with(['product.barang', 'product.kategori', 'product.outlet', 'outlet'])
            ->whereIn('outlet_id', $outletIds);

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

        // Filter outlet tertentu (jika dipilih)
        if (session()->has('selected_outlet_id')) {
            $selectedOutletId = session('selected_outlet_id');
            if (!empty($selectedOutletId) && $selectedOutletId !== 'all') {
                $query->where('outlet_id', $selectedOutletId);
            }
        }

        $totalData = StockMutation::whereIn('outlet_id', $outletIds)->count(); // total untuk lembaga ini

        // Global Search
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('type', 'like', "%{$search}%")
                    ->orWhere('quantity', 'like', "%{$search}%")
                    ->orWhereRaw("DATE_FORMAT(created_at, '%d-%m-%Y') like ?", ["%{$search}%"])
                    ->orWhereHas('product', function ($p) use ($search) {
                        $p->whereHas('barang', fn ($b) => $b->where('nama', 'like', "%{$search}%"))
                            ->orWhereHas('kategori', fn ($k) => $k->where('nama', 'like', "%{$search}%"))
                            ->orWhereHas('outlet', fn ($o) => $o->where('name', 'like', "%{$search}%"));
                    })
                    ->orWhereHas('outlet', fn ($o) => $o->where('name', 'like', "%{$search}%"));
            });
        }

        $totalFiltered = $query->count();

        // Ordering
        $orderColIndex = $request->input('order.0.column', 0);
        $orderDir = strtolower($request->input('order.0.dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        switch ($orderColIndex) {
            case 0: // created_at
                $query->orderBy('created_at', $orderDir);
                break;
            case 1: // outlet.name
                $query->join('outlet', 'stockmutation.outlet_id', '=', 'outlet.id')
                    ->orderBy('outlet.name', $orderDir)
                    ->select('stockmutation.*');
                break;
            case 2: // product.barang.nama
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
                $row->product->barang->nama ?? '-',
                ucfirst($row->type ?? ''),
                $row->quantity ?? 0,
                '<a href="' . route('laporan.stok.mutasi-stok.show', $row->id) . '" class="text-indigo-600 hover:underline font-medium menu-link">Detail</a>',
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

    public function show(Request $request, $id)
    {
        // Ambil data StockMutation beserta relasi product dan outlet
        $mutation = \App\Models\StockMutation::with(['product', 'outlet'])->findOrFail($id);

        if ($request->ajax()) {
            return view('laporan.mutasi-stok-detail', compact('mutation'));
        }

        return view('layouts.admin', [
            'slot' => view('laporan.mutasi-stok-detail', compact('mutation')),
            'title' => 'Detail Mutasi Stok',
            'lembaga' => \App\Models\Lembaga::find(session('current_lembaga_id')),
        ]);
    }

}
