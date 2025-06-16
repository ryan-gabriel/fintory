<?php

namespace App\Http\Controllers;

use App\Models\CashLedger;
use App\Models\Outlet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LaporanKeuanganController extends Controller
{
    public function getData(Request $request)
    {
        $columns = [
            0 => 'tanggal',
            1 => 'outlet.name',
            2 => 'tipe',
            3 => 'sumber',
            4 => 'deskripsi',
            5 => 'amount',
            6 => 'saldo_setelah',
        ];

        $currentLembagaId = session('current_lembaga_id');

        // Ambil semua outlet_id milik lembaga aktif
        $outletIds = Outlet::where('lembaga_id', $currentLembagaId)->pluck('id');

        // Query dasar
        $query = CashLedger::with('outlet')->whereIn('outlet_id', $outletIds);

        if ($request->filled('start_date')) {
            try {
                $startDate = Carbon::createFromFormat('m/d/Y', $request->start_date)->startOfDay();
                $query->where('tanggal', '>=', $startDate);
            } catch (\Exception $e) {
                Log::warning('Invalid start_date format: ' . $request->start_date);
            }
        }

        if ($request->filled('end_date')) {
            try {
                $endDate = Carbon::createFromFormat('m/d/Y', $request->end_date)->endOfDay();
                $query->where('tanggal', '<=', $endDate);
            } catch (\Exception $e) {
                Log::warning('Invalid end_date format: ' . $request->end_date);
            }
        }

        if (session()->has('selected_outlet_id')) {
            $selectedOutletId = session('selected_outlet_id');
            if (!empty($selectedOutletId) && $selectedOutletId !== 'all') {
                $query->where('outlet_id', $selectedOutletId);
            }
        }

        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('sumber', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")
                ->orWhere('tipe', 'like', "%{$search}%")
                ->orWhereRaw("DATE_FORMAT(tanggal, '%d-%m-%Y') like ?", ["%{$search}%"])
                ->orWhereHas('outlet', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
        }

        $totalData = CashLedger::whereIn('outlet_id', $outletIds)->count();
        $totalFiltered = $query->count();

        // Ordering
        $orderColIndex = $request->input('order.0.column', 0);
        $orderDir = strtolower($request->input('order.0.dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        $orderCol = $columns[$orderColIndex] ?? 'tanggal';

        if ($orderCol === 'outlet.name') {
            $query->join('outlet', 'outlet.id', '=', 'cashledger.outlet_id')
                ->orderBy('outlet.name', $orderDir)
                ->select('cashledger.*');
        } else {
            $query->orderBy($orderCol, $orderDir);
        }

        // Pagination
        $start = max(0, intval($request->input('start', 0)));
        $length = max(1, intval($request->input('length', 10)));

        $data = $query->skip($start)->take($length)->get();

        // JSON output
        $jsonData = [
            "draw" => intval($request->input('draw', 1)),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data" => [],
        ];

        foreach ($data as $row) {
            $jsonData['data'][] = [
                $row->tanggal ? date('d-m-Y', strtotime($row->tanggal)) : '-',
                $row->outlet->name ?? '-',
                ucfirst($row->tipe),
                $row->sumber ?? '-',
                $row->deskripsi ?? '-',
                'Rp ' . number_format($row->amount, 0, ',', '.'),
                'Rp ' . number_format($row->saldo_setelah, 0, ',', '.'),
                '<a href="' . route('laporan.keuangan.show', $row->id) . '" class="text-indigo-600 hover:underline font-medium menu-link">Detail</a>'
            ];
        }

        return response()->json($jsonData);
    }
    
    public function index(Request $request)
    {
        $currentLembagaId = session('current_lembaga_id');

        // Ambil semua outlet milik lembaga aktif
        $outlets = \App\Models\Outlet::where('lembaga_id', $currentLembagaId)->get();
        $selectedOutletId = session('selected_outlet_id', 'all');

        $selectedOutletName = $selectedOutletId === 'all'
            ? 'Semua Outlet'
            : optional($outlets->firstWhere('id', $selectedOutletId))->name ?? '-';

        if ($selectedOutletId !== 'all') {
            $totalHutang = \App\Models\Hutang::where('outlet_id', $selectedOutletId)
                ->orderByDesc('tanggal_hutang')
                ->value('sisa_hutang') ?? 0;

            $totalSaldo = \App\Models\OutletBalance::where('outlet_id', $selectedOutletId)->value('saldo') ?? 0;
        } else {
            // Ambil semua outlet_id dari lembaga aktif
            $outletIds = $outlets->pluck('id');

            // Ambil hutang terbaru per outlet
            $latestHutangIds = \App\Models\Hutang::whereIn('outlet_id', $outletIds)
                ->selectRaw('MAX(id) as id')
                ->groupBy('outlet_id')
                ->pluck('id');

            $totalHutang = \App\Models\Hutang::whereIn('id', $latestHutangIds)->sum('sisa_hutang');
            $totalSaldo = \App\Models\OutletBalance::whereIn('outlet_id', $outletIds)->sum('saldo');
        }

        $viewData = compact('outlets', 'selectedOutletId', 'selectedOutletName', 'totalHutang', 'totalSaldo');

        if ($request->ajax()) {
            return view('laporan.keuangan', $viewData);
        }

        return view('layouts.admin', [
            'slot' => view('laporan.keuangan', $viewData),
            'title' => 'Laporan Keuangan',
            'lembaga' => \App\Models\Lembaga::find($currentLembagaId),
        ]);
    }


    public function show(Request $request, $id)
    {
        $kasLedger = CashLedger::with('outlet')->findOrFail($id);

        $viewData = compact('kasLedger');

        if ($request->ajax()) {
            return view('laporan.keuangan-detail', $viewData);
        }

        return view('layouts.admin', [
            'slot' => view('laporan.keuangan-detail', $viewData),
            'title' => 'Laporan Keuangan',
            'lembaga' => \App\Models\Lembaga::find(session('current_lembaga_id')),
        ]);
    }
}
