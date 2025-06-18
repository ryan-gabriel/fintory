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
    /**
     * Menampilkan halaman utama yang sekarang berfungsi sebagai daftar hutang.
     */
    public function index(Request $request)
    {
        $viewData = [
            'title' => 'Daftar Hutang & Cicilan',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ];

        if ($request->ajax()) {
            return view('keuangan.cicilan', $viewData);
        }

        return view('layouts.admin', [
            'slot' => view('keuangan.cicilan', $viewData),
            'title' => $viewData['title'],
            'lembaga' => $viewData['lembaga'],
        ]);
    }

    /**
     * Menyediakan data untuk DataTables di halaman cicilan.
     */
    public function getData(Request $request)
    {
        try {
            $columns = [
                0 => 'hutang.tanggal_hutang',
                1 => 'hutang.nama_pemberi_hutang',
                2 => 'hutang.jumlah',
                3 => 'hutang.sisa_hutang',
            ];

            $currentLembagaId = session('current_lembaga_id');
            if (!$currentLembagaId) {
                return response()->json(["draw" => intval($request->input('draw')), "recordsTotal" => 0, "recordsFiltered" => 0, "data" => []], 400);
            }
            $outletIds = Outlet::where('lembaga_id', $currentLembagaId)->pluck('id');

            $query = Hutang::with(['outlet', 'cicilan' => function ($q) {
                $q->latest('tanggal_bayar');
            }])->whereIn('outlet_id', $outletIds);

            if (session()->has('selected_outlet_id')) {
                $selectedOutletId = session('selected_outlet_id');
                if (!empty($selectedOutletId) && $selectedOutletId !== 'all') {
                    $query->where('outlet_id', $selectedOutletId);
                }
            }
            
            $totalData = $query->clone()->count();
            $totalFiltered = $totalData;

            if ($request->filled('search.value')) {
                $search = $request->input('search.value');
                $query->where(function ($q) use ($search) {
                    $q->where('nama_pemberi_hutang', 'LIKE', "%{$search}%")
                      ->orWhere('jumlah', 'LIKE', "%{$search}%")
                      ->orWhere('sisa_hutang', 'LIKE', "%{$search}%");
                });
                $totalFiltered = $query->clone()->count();
            }

            if ($request->filled('start_date') && $request->filled('end_date')) {
                 try {
                    $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date)->startOfDay();
                    $endDate = Carbon::createFromFormat('d-m-Y', $request->end_date)->endOfDay();
                    $query->whereBetween('hutang.tanggal_hutang', [$startDate, $endDate]);
                    $totalFiltered = $query->clone()->count();
                } catch (\Exception $e) {
                    Log::error("Format tanggal salah pada filter: " . $e->getMessage());
                }
            }

            $orderColumnIndex = $request->input('order.0.column', 0);
            $orderDir = $request->input('order.0.dir', 'desc');
            if (isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDir);
            }

            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $hutangData = $query->skip($start)->take($length)->get();

            $formattedData = [];
            foreach ($hutangData as $hutang) {
                $latestCicilan = $hutang->cicilan->first();
                $bayarUrl = route('keuangan.cicilan.create', ['hutang_id' => $hutang->id]);
                
                $actionButtons = '
                    <div class="flex space-x-2">
                        <a href="' . $bayarUrl . '" class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700 transition create-link" data-title="Bayar Cicilan">Bayar</a>
                    </div>';

                $formattedData[] = [
                    'tanggal_hutang'      => $hutang->tanggal_hutang ? Carbon::parse($hutang->tanggal_hutang)->format('d-m-Y') : '-',
                    'nama_pemberi_hutang' => $hutang->nama_pemberi_hutang ?? '-',
                    'jumlah'              => 'Rp ' . number_format($hutang->jumlah ?? 0, 0, ',', '.'),
                    'sisa_hutang'         => 'Rp ' . number_format($hutang->sisa_hutang ?? 0, 0, ',', '.'),
                    'metode_pembayaran'   => $latestCicilan ? ($latestCicilan->metode_pembayaran ?? 'N/A') : 'Belum Bayar',
                    'tanggal_bayar'       => $latestCicilan ? Carbon::parse($latestCicilan->tanggal_bayar)->format('d-m-Y') : 'Belum Bayar',
                    'action'              => $actionButtons,
                ];
            }

            return response()->json([
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $formattedData,
            ]);

        } catch (\Exception $e) {
            Log::error('Error in CicilanController@getData: ' . $e->getMessage() . ' at line ' . $e->getLine());
            return response()->json(['error' => 'Terjadi kesalahan pada server.'], 500);
        }
    }

    /**
     * Menampilkan form untuk membuat cicilan baru (form pembayaran).
     */
    public function create(Request $request)
    {
        $lembagaId = session('current_lembaga_id');
        $hutangs = Hutang::where('sisa_hutang', '>', 0)
            ->whereHas('outlet', function ($query) use ($lembagaId) {
                $query->where('lembaga_id', $lembagaId);
            })
            ->orderBy('tanggal_hutang', 'desc')
            ->get();
        
        $selectedHutangId = $request->query('hutang_id');

        $viewData = [
            'hutangs' => $hutangs,
            'selectedHutangId' => $selectedHutangId,
            'title' => 'Bayar Cicilan',
            'lembaga' => Lembaga::find($lembagaId),
        ];

        if ($request->ajax()) {
            return view('keuangan.cicilan-create', $viewData);
        }
        
        return view('layouts.admin', [
            'slot' => view('keuangan.cicilan-create', $viewData),
            'title' => 'Bayar Cicilan',
            'lembaga' => Lembaga::find($lembagaId),
        ]);
    }

    /**
     * Menyimpan data cicilan baru ke database.
     * PERUBAHAN UTAMA ADA DI SINI.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hutang_id' => 'required|exists:hutang,id',
            'jumlah_bayar' => 'required|numeric|min:1',
            'tanggal_bayar' => 'required|date_format:d-m-Y',
            'metode_pembayaran' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            // Mengembalikan error validasi dalam format JSON
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $hutang = Hutang::findOrFail($request->hutang_id);

        if (floatval($request->jumlah_bayar) > floatval($hutang->sisa_hutang)) {
            // Mengembalikan pesan error dalam format JSON
            return response()->json(['success' => false, 'message' => 'Jumlah bayar tidak boleh melebihi sisa hutang.'], 400);
        }

        Cicilan::create([
            'hutang_id' => $request->hutang_id,
            'jumlah_bayar' => $request->jumlah_bayar,
            'tanggal_bayar' => Carbon::createFromFormat('d-m-Y', $request->tanggal_bayar)->format('Y-m-d'),
            'metode_pembayaran' => $request->metode_pembayaran,
            'deskripsi' => $request->deskripsi,
            'created_by' => auth()->id(),
        ]);

        // Update sisa hutang
        $hutang->sisa_hutang -= $request->jumlah_bayar;
        $hutang->save();

        // Mengembalikan respon sukses dengan instruksi redirect dalam format JSON
        return response()->json([
            'success' => true, 
            'message' => 'Pembayaran cicilan berhasil ditambahkan', 
            'redirect' => route('keuangan.cicilan.index')
        ]);
    }

    public function edit(Request $request, $id)
    {
        $lembagaId = session('current_lembaga_id');
        $cicilan = Cicilan::with('hutang')->findOrFail($id);

        $hutangs = Hutang::whereHas('outlet', function ($query) use ($lembagaId) {
            $query->where('lembaga_id', $lembagaId);
        })
        ->where('sisa_hutang', '>', 0)
        ->get();

        if ($request->ajax()) {
            return view('keuangan.cicilan-edit', compact('cicilan', 'hutangs'));
        }

        return view('layouts.admin', [
            'slot' => view('keuangan.cicilan-edit', compact('cicilan', 'hutangs')),
            'title' => 'Edit Cicilan',
            'lembaga' => Lembaga::find($lembagaId),
        ]);
    }
    
    public function update(Request $request, $id)
    {
        // ... (Kode update Anda sudah benar, menggunakan response()->json()) ...
        $cicilan = Cicilan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'hutang_id' => 'required|exists:hutang,id',
            'tanggal_bayar' => ['required', function ($attribute, $value, $fail) {
                try { \Carbon\Carbon::createFromFormat('d-m-Y', $value); } catch (\Exception $e) { $fail('Format tanggal tidak valid. Gunakan format dd-mm-yyyy.'); }
            }],
            'jumlah_bayar' => 'required|numeric|min:1',
            'metode_pembayaran' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'errors' => $validator->errors()], 422);
        }

        $oldJumlahBayar = $cicilan->jumlah_bayar;
        $hutang = Hutang::find($cicilan->hutang_id);
        $tanggalBayar = Carbon::createFromFormat('d-m-Y', $request->tanggal_bayar)->format('Y-m-d');

        $cicilan->fill($request->all());
        $cicilan->tanggal_bayar = $tanggalBayar;
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

        return response()->json(['success' => true, 'message' => 'Cicilan berhasil diupdate.', 'redirect' => route('keuangan.cicilan.index')]);
    }
    
    public function destroy($id)
    {
        // ... (Kode destroy Anda sudah benar, menggunakan response()->json()) ...
        $cicilan = Cicilan::findOrFail($id);
        $hutang = Hutang::find($cicilan->hutang_id);
        $hutang->sisa_hutang += $cicilan->jumlah_bayar;
        $hutang->save();
        $cicilan->delete();
        return response()->json(['success' => true, 'message' => 'Cicilan berhasil dihapus.']);
    }
}