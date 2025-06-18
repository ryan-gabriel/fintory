<?php

namespace App\Http\Controllers;

use App\Models\CashLedger;
use App\Models\Lembaga;
use App\Models\Outlet;
use App\Models\OutletBalance;
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

        $currentLembagaId = session('current_lembaga_id');

        // Ambil semua outlet_id yang termasuk dalam lembaga ini
        $outletIds = Outlet::where('lembaga_id', $currentLembagaId)->pluck('id');

        // Filter awal: hanya ambil kas dari outlet yang masuk lembaga
        $query = CashLedger::whereIn('outlet_id', $outletIds);

        // Filter tanggal
        if ($request->filled('start_date')) {
            try {
                $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date)->startOfDay();
                $query->where('tanggal', '>=', $startDate);
            } catch (\Exception $e) {
                Log::warning('Invalid start_date format: ' . $request->start_date);
            }
        }

        if ($request->filled('end_date')) {
            try {
                $endDate = Carbon::createFromFormat('d-m-Y', $request->end_date)->endOfDay();
                $query->where('tanggal', '<=', $endDate);
            } catch (\Exception $e) {
                Log::warning('Invalid end_date format: ' . $request->end_date);
            }
        }

        // Jika user memilih outlet tertentu
        if (session()->has('selected_outlet_id')) {
            $selectedOutletId = session('selected_outlet_id');
            if (!empty($selectedOutletId) && $selectedOutletId !== 'all') {
                $query->where('outlet_id', $selectedOutletId);
            }
        }

        // Search global
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('tipe', 'like', "%{$search}%")
                ->orWhere('sumber', 'like', "%{$search}%")
                ->orWhere('amount', 'like', "%{$search}%")
                ->orWhereRaw("DATE_FORMAT(tanggal, '%d-%m-%Y') like ?", ["%{$search}%"]);
            });
        }

        $totalData = CashLedger::whereIn('outlet_id', $outletIds)->count();
        $totalFiltered = $query->count();

        $orderColIndex = intval($request->input('order.0.column', 0));
        $orderDir = strtolower($request->input('order.0.dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        $orderCol = $columns[$orderColIndex] ?? 'tanggal';
        $query->orderBy($orderCol, $orderDir);

        $start = max(0, intval($request->input('start', 0)));
        $length = max(1, intval($request->input('length', 10)));
        $data = $query->offset($start)->limit($length)->get();

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
                    <button type="button" class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700 transition delete-btn" data-id="<?= $row->id ?>" data-url="<?= $deleteUrl ?>">Delete</button>
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
    
    public function create(Request $request)
    {
        $lembagaId = session('current_lembaga_id');

        $outlets = Outlet::where('lembaga_id', $lembagaId)->get();

        if ($request->ajax()) {
            return view('keuangan.kas-ledger-create', compact('outlets'));
        }

        return view('layouts.admin', [
            'slot' => view('keuangan.kas-ledger-create', compact('outlets')),
            'title' => 'Tambah Kas & Ledger',
            'lembaga' => Lembaga::find($lembagaId),
        ]);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date_format:d-m-Y',
            'tipe' => 'required|string|in:INCOME,EXPENSE,TRANSFER_IN,TRANSFER_OUT',
            'sumber' => 'nullable|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'outlet_id' => 'required|exists:outlet,id',
            'deskripsi' => 'required|string|max:255',
        ]);

        $tanggal = Carbon::createFromFormat('d-m-Y', $request->tanggal)->startOfDay();
        $jumlah = $request->jumlah;
        $tipe = strtoupper($request->tipe);
        $outletId = $request->outlet_id;

        try {
            DB::beginTransaction();

            // Ambil saldo terakhir dari OutletBalance
            $outletBalance = OutletBalance::firstOrCreate(
                ['outlet_id' => $outletId],
                ['saldo' => 0, 'last_updated' => now()]
            );

            $saldoSebelum = $outletBalance->saldo;

            // Validasi saldo cukup
            if (in_array($tipe, ['EXPENSE', 'TRANSFER_OUT']) && $saldoSebelum < $jumlah) {
                return redirect()->back()->withInput()->withErrors([
                    'jumlah' => 'Saldo tidak mencukupi untuk pengeluaran atau transfer keluar.',
                ]);
            }

            // Hitung saldo setelah
            $saldoSetelah = in_array($tipe, ['EXPENSE', 'TRANSFER_OUT']) 
                ? $saldoSebelum - $jumlah 
                : $saldoSebelum + $jumlah;

            // Simpan ke CashLedger
            \App\Models\CashLedger::create([
                'tanggal' => $tanggal,
                'tipe' => $tipe,
                'sumber' => $request->sumber,
                'amount' => $jumlah,
                'saldo_sebelum' => $saldoSebelum,
                'saldo_setelah' => $saldoSetelah,
                'outlet_id' => $outletId,
                'deskripsi' => $request->deskripsi,
                'created_by' => auth()->id(),
            ]);

            // Update saldo outlet
            $outletBalance->update([
                'saldo' => $saldoSetelah,
                'last_updated' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('keuangan.kas-ledger.index')
                ->with('success', 'Data kas ledger berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal menyimpan kas ledger: " . $e->getMessage());

            return redirect()->back()->withInput()->withErrors([
                'general' => 'Terjadi kesalahan saat menyimpan transaksi kas.',
            ]);
        }
    }


    public function edit($id, Request $request)
    {
        $lembagaId = session('current_lembaga_id');

        $kasLedger = CashLedger::findOrFail($id);

        $outlets = Outlet::where('lembaga_id', $lembagaId)->get();

        if ($request->ajax()) {
            return view('keuangan.kas-ledger-edit', compact('kasLedger', 'outlets'));
        }

        return view('layouts.admin', [
            'slot' => view('keuangan.kas-ledger-edit', compact('kasLedger', 'outlets')),
            'title' => 'Edit Kas & Ledger',
            'lembaga' => Lembaga::find($lembagaId),
        ]);
    }


    public function update(Request $request, $id)
    {
        $kasLedger = CashLedger::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date_format:d-m-Y',
            'tipe' => 'required|string|in:INCOME,EXPENSE,TRANSFER_IN,TRANSFER_OUT',
            'sumber' => 'nullable|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'outlet_id' => 'required|exists:outlet,id',
            'deskripsi' => 'required|string|max:255',
        ]);

        $tanggal = Carbon::createFromFormat('d-m-Y', $request->tanggal)->startOfDay();
        $jumlah = $request->jumlah;
        $tipeBaru = strtoupper($request->tipe);

        // Ambil saldo dari OutletBalance
        $outletBalance = OutletBalance::where('outlet_id', $request->outlet_id)->first();
        if (!$outletBalance) {
            return redirect()->back()->withInput()->withErrors([
                'outlet_id' => 'Saldo outlet tidak ditemukan.',
            ]);
        }

        // Kembalikan saldo karena kasLedger lama akan ditimpa
        $saldoLama = $kasLedger->amount;
        if (in_array($kasLedger->tipe, ['EXPENSE', 'TRANSFER_OUT'])) {
            $outletBalance->saldo += $saldoLama;
        } else {
            $outletBalance->saldo -= $saldoLama;
        }

        // Hitung saldo_sebelum baru dari outletbalance yang sudah direkalkulasi
        $saldoSebelum = $outletBalance->saldo;

        // Validasi saldo cukup
        if (in_array($tipeBaru, ['EXPENSE', 'TRANSFER_OUT']) && $saldoSebelum < $jumlah) {
            return redirect()->back()->withInput()->withErrors([
                'jumlah' => 'Saldo tidak mencukupi untuk pengeluaran atau transfer keluar.',
            ]);
        }

        // Hitung saldo setelah
        $saldoSetelah = in_array($tipeBaru, ['EXPENSE', 'TRANSFER_OUT'])
            ? $saldoSebelum - $jumlah
            : $saldoSebelum + $jumlah;

        // Update data kas ledger
        $kasLedger->update([
            'tanggal' => $tanggal,
            'tipe' => $tipeBaru,
            'sumber' => $request->sumber,
            'amount' => $jumlah,
            'saldo_sebelum' => $saldoSebelum,
            'saldo_setelah' => $saldoSetelah,
            'outlet_id' => $request->outlet_id,
            'deskripsi' => $request->deskripsi,
        ]);

        // Simpan saldo baru ke outlet_balance
        $outletBalance->saldo = $saldoSetelah;
        $outletBalance->last_updated = now();
        $outletBalance->save();

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
