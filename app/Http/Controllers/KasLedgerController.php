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

        if (session()->has('selected_outlet_id')) {
            $selectedOutletId = session('selected_outlet_id');
            if (!empty($selectedOutletId) && $selectedOutletId !== 'all') {
                $query->where('outlet_id', $selectedOutletId);
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

            $editUrl = route('keuangan.kas-ledger.edit', $row->id);
            $deleteUrl = route('keuangan.kas-ledger.destroy', $row->id);

            ob_start(); ?>
                <div class="flex space-x-2">
                    <a href="<?= $editUrl ?>" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700 transition edit-link">Edit</a>
                    <button type="button" class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700 transition delete-btn confirm-delete" data-id="<?= $row->id ?>" data-url="<?= $deleteUrl ?>">Delete</button>
                </div>

                
            <?php
            $actionButtons = ob_get_clean();
            
            $jsonData['data'][] = [
                $row->tanggal ? Carbon::parse($row->tanggal)->format('d-m-Y') : '-',
                $row->tipe ? ucfirst($row->tipe) : '-',
                $row->sumber ?? '-',
                'Rp ' . number_format($row->amount ?? 0, 0, ',', '.'),
                'Rp ' . number_format($row->saldo_setelah ?? 0, 0, ',', '.'),
                $actionButtons
            ];
        }

        return response()->json($jsonData);
    }


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
    
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date_format:m/d/Y',
            'tipe' => 'required|string|in:INCOME,EXPENSE,TRANSFER_IN,TRANSFER_OUT',
            'sumber' => 'nullable|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'outlet_id' => 'required|exists:outlet,id',
            'deskripsi' => 'required|string|max:255',
        ]);

        $tanggal = Carbon::createFromFormat('m/d/Y', $request->tanggal)->startOfDay();
        $jumlah = $request->jumlah;
        $tipe = strtoupper($request->tipe);

        $saldoSebelum = CashLedger::where('outlet_id', $request->outlet_id)
            ->where('tanggal', '<=', $tanggal)
            ->orderBy('tanggal', 'desc')
            ->value('saldo_setelah') ?? 0;

        // Cek saldo untuk tipe pengeluaran / transfer keluar
        if (in_array($tipe, ['EXPENSE', 'TRANSFER_OUT']) && $saldoSebelum < $jumlah) {
            return redirect()->back()->withInput()->withErrors([
                'jumlah' => 'Saldo tidak mencukupi untuk pengeluaran atau transfer keluar.',
            ]);
        }

        // Hitung saldo setelah
        $saldoSetelah = in_array($tipe, ['EXPENSE', 'TRANSFER_OUT']) 
            ? $saldoSebelum - $jumlah 
            : $saldoSebelum + $jumlah;

        CashLedger::create([
            'tanggal' => $tanggal,
            'tipe' => $tipe,
            'sumber' => $request->sumber,
            'amount' => $jumlah,
            'saldo_sebelum' => $saldoSebelum,
            'saldo_setelah' => $saldoSetelah,
            'outlet_id' => $request->outlet_id,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('keuangan.kas-ledger.index') // ganti sesuai rute daftar kas ledger kamu
            ->with('success', 'Data kas ledger berhasil disimpan.');
    }
    public function edit($id, Request $request)
    {
        $kasLedger = CashLedger::findOrFail($id);
        $outlets = Outlet::all();

        if ($request->ajax()) {
            return view('keuangan.kas-ledger-edit', compact('kasLedger', 'outlets'));
        }
        return view('layouts.admin', [
            'slot' => view('keuangan.kas-ledger-edit', compact('kasLedger', 'outlets')),
            'title' => 'Edit Kas & Ledger',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    public function update(Request $request, $id)
    {
        $kasLedger = CashLedger::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date_format:m/d/Y',
            'tipe' => 'required|string|in:INCOME,EXPENSE,TRANSFER_IN,TRANSFER_OUT',
            'sumber' => 'nullable|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'outlet_id' => 'required|exists:outlet,id',
            'deskripsi' => 'required|string|max:255',
        ]);

        $tanggal = Carbon::createFromFormat('m/d/Y', $request->tanggal)->startOfDay();
        $jumlah = $request->jumlah;
        $tipe = strtoupper($request->tipe);

        $saldoSebelum = CashLedger::where('outlet_id', $request->outlet_id)
            ->where('tanggal', '<=', $tanggal)
            ->where('id', '!=', $kasLedger->id)
            ->orderBy('tanggal', 'desc')
            ->value('saldo_setelah') ?? 0;

        if (in_array($tipe, ['EXPENSE', 'TRANSFER_OUT']) && $saldoSebelum < $jumlah) {
            return redirect()->back()->withInput()->withErrors([
                'jumlah' => 'Saldo tidak mencukupi untuk pengeluaran atau transfer keluar.',
            ]);
        }

        $saldoSetelah = in_array($tipe, ['EXPENSE', 'TRANSFER_OUT'])
            ? $saldoSebelum - $jumlah
            : $saldoSebelum + $jumlah;

        $kasLedger->update([
            'tanggal' => $tanggal,
            'tipe' => $tipe,
            'sumber' => $request->sumber,
            'amount' => $jumlah,
            'saldo_sebelum' => $saldoSebelum,
            'saldo_setelah' => $saldoSetelah,
            'outlet_id' => $request->outlet_id,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('keuangan.kas-ledger.index')
            ->with('success', 'Data kas ledger berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kasLedger = CashLedger::findOrFail($id);
        $kasLedger->delete();

        return response()->json(['success' => true, 'message' => 'Data kas ledger berhasil dihapus.']);
    }

}
