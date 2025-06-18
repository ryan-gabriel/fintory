<?php

namespace App\Http\Controllers;

use App\Models\Cicilan;
use App\Models\Hutang;
use App\Models\Lembaga;
use App\Models\Outlet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CicilanController extends Controller
{
    public function getData(Request $request)
    {
        $columns = [
            0 => 'tanggal_bayar',
            1 => 'hutang.nama_pemberi_hutang',
            2 => 'jumlah_bayar',
            3 => 'hutang.sisa_hutang',
            4 => 'metode_pembayaran',
        ];

        $currentLembagaId = session('current_lembaga_id');

        // Ambil ID outlet yang terkait dengan lembaga ini
        $outletIds = Outlet::where('lembaga_id', $currentLembagaId)->pluck('id');

        // Query dasar: hanya cicilan dari hutang yang outlet-nya termasuk lembaga ini
        $query = Cicilan::with(['hutang.outlet'])->whereHas('hutang', function ($q) use ($outletIds) {
            $q->whereIn('outlet_id', $outletIds);
        });

        if ($request->filled('start_date')) {
            try {
                $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date)->startOfDay();
                $query->where('tanggal_bayar', '>=', $startDate);
            } catch (\Exception $e) {
                Log::warning('Invalid start_date format: ' . $request->start_date);
            }
        }

        if ($request->filled('end_date')) {
            try {
                $endDate = Carbon::createFromFormat('d-m-Y', $request->end_date)->endOfDay();
                $query->where('tanggal_bayar', '<=', $endDate);
            } catch (\Exception $e) {
                Log::warning('Invalid end_date format: ' . $request->end_date);
            }
        }

        if (session()->has('selected_outlet_id')) {
            $selectedOutletId = session('selected_outlet_id');
            if (!empty($selectedOutletId) && $selectedOutletId !== 'all') {
                $query->whereHas('hutang', function ($q) use ($selectedOutletId) {
                    $q->where('outlet_id', $selectedOutletId);
                });
            }
        }

        // Hitung total (tanpa filter pencarian)
        $totalData = Cicilan::whereHas('hutang', function ($q) use ($outletIds) {
            $q->whereIn('outlet_id', $outletIds);
        })->count();

        // Filter pencarian
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('jumlah_bayar', 'like', "%{$search}%")
                ->orWhere('metode_pembayaran', 'like', "%{$search}%")
                ->orWhereRaw("DATE_FORMAT(tanggal_bayar, '%d-%m-%Y') like ?", ["%{$search}%"])
                ->orWhereHas('hutang', function ($q2) use ($search) {
                    $q2->where('nama_pemberi_hutang', 'like', "%{$search}%")
                        ->orWhere('sisa_hutang', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%")
                        ->orWhereHas('outlet', function ($q3) use ($search) {
                            $q3->where('name', 'like', "%{$search}%");
                        });
                });
            });
        }

        $totalFiltered = $query->count();

        // Sorting
        $orderColIndex = $request->input('order.0.column', 4);
        $orderDir = strtolower($request->input('order.0.dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        $orderCol = $columns[$orderColIndex] ?? 'tanggal_bayar';

        if ($orderCol === 'hutang.nama_pemberi_hutang' || $orderCol === 'hutang.sisa_hutang' || $orderCol === 'outlet.name') {
            $query->join('hutang', 'hutang.id', '=', 'cicilan.hutang_id');

            if ($orderCol === 'outlet.name') {
                $query->join('outlet', 'outlet.id', '=', 'hutang.outlet_id')
                    ->orderBy('outlet.name', $orderDir);
            } elseif ($orderCol === 'hutang.nama_pemberi_hutang') {
                $query->orderBy('hutang.nama_pemberi_hutang', $orderDir);
            } elseif ($orderCol === 'hutang.sisa_hutang') {
                $query->orderBy('hutang.sisa_hutang', $orderDir);
            }

            $query->select('cicilan.*');
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
            $editUrl = route('keuangan.cicilan.edit', $row->id);
            $deleteUrl = route('keuangan.cicilan.destroy', $row->id);

            ob_start(); ?>
                <div class="flex space-x-2">
                    <a href="<?= $editUrl ?>" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700 transition edit-link">Edit</a>
                    <button type="button" class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700 transition delete-btn" data-id="<?= $row->id ?>" data-url="<?= $deleteUrl ?>">Delete</button>
                </div>
            <?php
            $actionButtons = ob_get_clean();

            $jsonData['data'][] = [
                $row->tanggal_bayar ? date('d-m-Y', strtotime($row->tanggal_bayar)) : '-',
                $row->hutang->nama_pemberi_hutang ?? '-',
                'Rp ' . number_format($row->jumlah_bayar ?? 0, 0, ',', '.'),
                'Rp ' . number_format($row->hutang->sisa_hutang ?? 0, 0, ',', '.'),
                $row->metode_pembayaran ?? '-',
                $actionButtons
            ];
        }

        return response()->json($jsonData);
    }
    
    public function index(Request $request){
        $cicilan = Cicilan::with(['hutang'])->orderBy('created_at', 'desc')->get();
        if ($request->ajax()) {
            return view('keuangan.cicilan', compact('cicilan'));
        }
        return view('layouts.admin', [
            'slot' => view('keuangan.cicilan', compact('cicilan')),
            'title' => 'Cicilan',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    public function create(Request $request){
        $hutangs = Hutang::all();
        if ($request->ajax()) {
            return view('keuangan.cicilan-create', compact('hutangs'));
        }
        return view('layouts.admin', [
            'slot' => view('keuangan.cicilan-create', compact('hutangs')),
            'title' => 'Tambah Cicilan',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
            ]
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'hutang_id' => 'required|exists:hutang,id',
            'tanggal_bayar' => [
                'required',
                function ($attribute, $value, $fail) {
                    try {
                        \Carbon\Carbon::createFromFormat('d-m-Y', $value);
                    } catch (\Exception $e) {
                        $fail('Format tanggal tidak valid. Gunakan format mm/dd/yyyy.');
                    }
                }
            ],
            'jumlah_bayar' => 'required|numeric|min:1',
            'metode_pembayaran' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
        ]);

        // Konversi tanggal_bayar ke format Y-m-d
        $tanggalBayar = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_bayar)->format('Y-m-d');

        $cicilan = new Cicilan();
        $cicilan->hutang_id = $request->hutang_id;
        $cicilan->tanggal_bayar = $tanggalBayar;
        $cicilan->jumlah_bayar = $request->jumlah_bayar;
        $cicilan->metode_pembayaran = $request->metode_pembayaran;
        $cicilan->deskripsi = $request->deskripsi;
        $cicilan->save();

        // Update sisa_hutang pada hutang terkait
        $hutang = Hutang::find($request->hutang_id);
        if ($hutang) {
            $hutang->sisa_hutang = max(0, $hutang->sisa_hutang - $request->jumlah_bayar);
            $hutang->save();
        }

        return redirect()->route('keuangan.cicilan.index')->with('success', 'Cicilan berhasil ditambahkan.');
    }
    public function edit($id, Request $request)
    {
        $cicilan = Cicilan::with('hutang')->findOrFail($id);
        $hutangs = Hutang::all();
        if ($request->ajax()) {
            return view('keuangan.cicilan-edit', compact('cicilan', 'hutangs'));
        }
        return view('layouts.admin', [
            'slot' => view('keuangan.cicilan-edit', compact('cicilan', 'hutangs')),
            'title' => 'Edit Cicilan',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    public function update(Request $request, $id)
    {
        $cicilan = Cicilan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'hutang_id' => 'required|exists:hutang,id',
            'tanggal_bayar' => [
                'required',
                function ($attribute, $value, $fail) {
                    try {
                        \Carbon\Carbon::createFromFormat('d-m-Y', $value);
                    } catch (\Exception $e) {
                        $fail('Format tanggal tidak valid. Gunakan format dd-mm-yyyy.');
                    }
                }
            ],
            'jumlah_bayar' => 'required|numeric|min:1',
            'metode_pembayaran' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 422);
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Hitung selisih jumlah_bayar untuk update sisa_hutang
        $oldJumlahBayar = $cicilan->jumlah_bayar;
        $hutang = Hutang::find($cicilan->hutang_id);

        $tanggalBayar = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_bayar)->format('Y-m-d');

        $cicilan->hutang_id = $request->hutang_id;
        $cicilan->tanggal_bayar = $tanggalBayar;
        $cicilan->jumlah_bayar = $request->jumlah_bayar;
        $cicilan->metode_pembayaran = $request->metode_pembayaran;
        $cicilan->deskripsi = $request->deskripsi;
        $cicilan->save();

        if ($hutang && $cicilan->wasChanged('hutang_id')) {
            $hutang->sisa_hutang += $oldJumlahBayar;
            $hutang->save();

            $newHutang = Hutang::find($request->hutang_id);
            if ($newHutang) {
                $newHutang->sisa_hutang = max(0, $newHutang->sisa_hutang - $request->jumlah_bayar);
                $newHutang->save();
            }
        } elseif ($hutang) {
            $hutang->sisa_hutang = max(0, $hutang->sisa_hutang + $oldJumlahBayar - $request->jumlah_bayar);
            $hutang->save();
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cicilan berhasil diupdate.',
                'redirect' => route('keuangan.cicilan.index'),
            ]);
        }

        return redirect()->route('keuangan.cicilan.index')->with('success', 'Cicilan berhasil diupdate.');
    }


    public function destroy($id)
    {
        $currentLembagaId = session('current_lembaga_id');

        if (!$currentLembagaId) {
            return response()->json([
                'success' => false,
                'message' => 'Lembaga tidak ditemukan dalam sesi.'
            ], 403);
        }

        $cicilan = Cicilan::findOrFail($id);
        $hutang = Hutang::with('outlet')->find($cicilan->hutang_id);

        if (!$hutang || !$hutang->outlet || $hutang->outlet->lembaga_id != $currentLembagaId) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Hutang tidak sesuai dengan lembaga aktif.'
            ], 403);
        }

        // Kembalikan jumlah_bayar ke sisa_hutang
        $hutang->sisa_hutang += $cicilan->jumlah_bayar;
        $hutang->save();

        $cicilan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cicilan berhasil dihapus.'
        ]);
    }

}
