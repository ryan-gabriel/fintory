<?php

namespace App\Http\Controllers;

use App\Models\CashLedger;
use App\Models\Lembaga;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class KasLedgerController extends Controller
{
    public function index(Request $request){
        $cashLedger = CashLedger::with(['outlet'])
            ->orderBy('tanggal', 'desc')
            ->get();
      
        if ($request->ajax()) {
            return view('keuangan.kas-ledger', compact('cashLedger'));
        }
        return view('layouts.admin', [
            'slot' => view('keuangan.kas-ledger', compact('cashLedger')),
            'title' => 'Kas & Ledger',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }
    
    public function create(Request $request){
        $outlets = Outlet::all();
        if ($request->ajax()) {
            return view('keuangan.kas-ledger-create', compact('outlets'));
        }
        return view('layouts.admin', [
            'slot' => view('keuangan.kas-ledger-create', compact('outlets')),
            'title' => 'Tambah Kas & Ledger',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
            ]
        );
    }
    
    public function store(Request $request){
        $request->validate([
            'tanggal' => 'required|date',
            'tipe' => 'required|string|max:255',
            'sumber' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'outlet_id' => 'required|exists:outlets,id',
        ]);

        // $tipentay adalha berikut = ['INCOME','EXPENSE','TRANSFER_IN','TRANSFER_OUT','ADJUSTMENT'];
        $tanggal = Carbon::createFromFormat('m/d/Y', $request->tanggal)->startOfDay();
        $saldoSebelum = CashLedger::where('outlet_id', $request->outlet_id)
            ->where('tanggal', '<=', $tanggal)
            ->orderBy('tanggal', 'desc')
            ->value('saldo_setelah') ?? 0;

        if($saldoSebelum < 0 && $request->tipe === 'pengeluaran') {
            return view('layouts.admin', [
                'slot' => view('keuangan.kas-ledger-create', ['error' => 'Saldo tidak mencukupi untuk pengeluaran.']),
                'title' => 'Tambah Kas & Ledger',
                'lembaga' => Lembaga::find(session('current_lembaga_id')),
            ]);
        }
        if($saldoSebelum < 0 && $request->tipe === 'pemasukan') {
            return view('layouts.admin', [
                'slot' => view('keuangan.kas-ledger-create', ['error' => 'Saldo tidak mencukupi untuk pemasukan.']),
                'title' => 'Tambah Kas & Ledger',
                'lembaga' => Lembaga::find(session('current_lembaga_id')),
            ]);
        }
        if ($request->tipe === 'pengeluaran' && $saldoSebelum < $request->amount) {
            return view('layouts.admin', [
                'slot' => view('keuangan.kas-ledger-create', ['error' => 'Saldo tidak mencukupi untuk pengeluaran.']),
                'title' => 'Tambah Kas & Ledger',
                'lembaga' => Lembaga::find(session('current_lembaga_id')),
            ]);
        }
        if ($request->tipe === 'pemasukan' && $saldoSebelum < 0) {
            return view('layouts.admin', [
                'slot' => view('keuangan.kas-ledger-create', ['error' => 'Saldo tidak mencukupi untuk pemasukan.']),
                'title' => 'Tambah Kas & Ledger',
                'lembaga' => Lembaga::find(session('current_lembaga_id')),
            ]);
        }
        if ($request->tipe === 'pengeluaran') {
            $saldoSebelum -= $request->amount;
        } elseif ($request->tipe === 'pemasukan') {
            $saldoSebelum += $request->amount;
        } else {
            return view('layouts.admin', [
                'slot' => view('keuangan.kas-ledger-create', ['error' => 'Tipe tidak valid.']),
                'title' => 'Tambah Kas & Ledger',
                'lembaga' => Lembaga::find(session('current_lembaga_id')),
            ]);
        }



        $saldoSetelah = $saldoSebelum + $request->amount;
        CashLedger::create([
            'tanggal' => $tanggal,
            'tipe' => $request->tipe,
            'sumber' => $request->sumber,
            'amount' => $request->amount,
            'saldo_sebelum' => $saldoSebelum,
            'saldo_setelah' => $saldoSetelah,
            'outlet_id' => $request->outlet_id,
        ]);

        return view('layouts.admin', [
            'slot' => view('keuangan.kas-ledger-create', ['success' => 'Data kas ledger berhasil disimpan.']),
            'title' => 'Tambah Kas & Ledger',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    public function getData(Request $request)
    {
        $columns = [
            0 => 'tanggal',
            1 => 'tipe',
            2 => 'sumber',
            3 => 'amount',
            4 => 'saldo_setelah',
        ];

        $query = CashLedger::query();

        // Date range filter
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

        // Search filter
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('tipe', 'like', "%{$search}%")
                ->orWhere('sumber', 'like', "%{$search}%")
                ->orWhere('amount', 'like', "%{$search}%")
                ->orWhereRaw("DATE_FORMAT(tanggal, '%d-%m-%Y') like ?", ["%{$search}%"]);
            });
        }

        // Total data (tanpa filter)
        $totalData = CashLedger::count();

        // Total data (dengan filter)
        $totalFiltered = $query->count();

        // Ordering
        $orderColIndex = intval($request->input('order.0.column', 0));
        $orderDir = strtolower($request->input('order.0.dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        $orderCol = $columns[$orderColIndex] ?? 'tanggal';
        $query->orderBy($orderCol, $orderDir);

        // Pagination
        $start = max(0, intval($request->input('start', 0)));
        $length = max(1, intval($request->input('length', 10)));

        $data = $query->offset($start)->limit($length)->get();

        // Format response
        $jsonData = [
            'draw' => intval($request->input('draw', 1)),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => [],
        ];

        foreach ($data as $row) {
            $jsonData['data'][] = [
                $row->tanggal ? Carbon::parse($row->tanggal)->format('d-m-Y') : '-',
                $row->tipe ? ucfirst($row->tipe) : '-',
                $row->sumber ?? '-',
                'Rp ' . number_format($row->amount ?? 0, 0, ',', '.'),
                'Rp ' . number_format($row->saldo_setelah ?? 0, 0, ',', '.'),
                '<a href="/testing">testing</a>'
            ];
        }

        return response()->json($jsonData);
    }

}
