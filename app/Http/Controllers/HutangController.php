<?php

namespace App\Http\Controllers;

use App\Models\Hutang;
use App\Models\Lembaga;
use App\Models\Outlet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HutangController extends Controller
{
    public function getData(Request $request)
    {
        $columns = [
            0 => 'tanggal_hutang',
            1 => 'outlet.name',          // untuk sorting kolom outlet
            2 => 'nama_pemberi_hutang',
            3 => 'jumlah',
            4 => 'sisa_hutang',
        ];

        $query = Hutang::with('outlet'); // eager load relasi outlet

        if ($request->filled('start_date')) {
            try {
                $startDate = Carbon::createFromFormat('m/d/Y', $request->start_date)->startOfDay();
                $query->where('tanggal_hutang', '>=', $startDate);
            } catch (\Exception $e) {
                Log::warning('Invalid start_date format: ' . $request->start_date);
            }
        }

        if ($request->filled('end_date')) {
            try {
                $endDate = Carbon::createFromFormat('m/d/Y', $request->end_date)->endOfDay();
                $query->where('tanggal_hutang', '<=', $endDate);
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
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('nama_pemberi_hutang', 'like', "%{$search}%")
                ->orWhere('jumlah', 'like', "%{$search}%")
                ->orWhere('sisa_hutang', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")
                ->orWhereRaw("DATE_FORMAT(tanggal_hutang, '%d-%m-%Y') like ?", ["%{$search}%"])
                ->orWhereHas('outlet', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Get total and filtered count
        $totalData = Hutang::count();
        $totalFiltered = $query->count();

        // Ordering
        $orderColIndex = $request->input('order.0.column', 0);
        $orderDir = strtolower($request->input('order.0.dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        $orderCol = $columns[$orderColIndex] ?? 'tanggal_hutang';

        // Handle sorting by related column (e.g., outlet.nama)
        if ($orderCol === 'outlet.name') {
            $query->join('outlet', 'outlet.id', '=', 'hutang.outlet_id')
                ->orderBy('outlet.name', $orderDir)
                ->select('hutang.*'); // ensure hutang.* is selected after join
        } else {
            $query->orderBy($orderCol, $orderDir);
        }

        // Pagination
        $start = max(0, intval($request->input('start', 0)));
        $length = max(1, intval($request->input('length', 10)));

        $data = $query->skip($start)->take($length)->get();

        // Format JSON output
        $jsonData = [
            "draw" => intval($request->input('draw', 1)),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data" => [],
        ];

        foreach ($data as $row) {
            // $modalId = 'popup-modal-' . $row->id;
            $editUrl = route('keuangan.hutang.edit', $row->id);
            $deleteUrl = route('keuangan.hutang.destroy', $row->id);

            ob_start(); ?>
                <div class="flex space-x-2">
                    <a href="<?= $editUrl ?>" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700 transition edit-link">Edit</a>
                    <button type="button" class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700 transition delete-btn confirm-delete" data-id="<?= $row->id ?>" data-url="<?= $deleteUrl ?>">Delete</button>
                </div>

                
            <?php
            $actionButtons = ob_get_clean();

            $jsonData['data'][] = [
                $row->tanggal_hutang ? date('d-m-Y', strtotime($row->tanggal_hutang)) : '-',
                $row->outlet->name ?? '-',
                $row->nama_pemberi_hutang ?? '-',
                'Rp ' . number_format($row->jumlah, 0, ',', '.'),
                'Rp ' . number_format($row->sisa_hutang, 0, ',', '.'),
                $actionButtons
            ];
        }


        return response()->json($jsonData);
    }


    public function index(Request $request){
        $hutang = Hutang::with(['outlet'])->orderBy('created_at', 'desc')->get();
        if ($request->ajax()) {
            return view('keuangan.hutang', compact('hutang'));
        }
        return view('layouts.admin', [
            'slot' => view('keuangan.hutang', compact('hutang')),
            'title' => 'Hutang',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }
    
    public function create(Request $request){
        $outlets = Outlet::all();
        if ($request->ajax()) {
            return view('keuangan.hutang-create', compact('outlets'));
        }
        return view('layouts.admin', [
            'slot' => view('keuangan.hutang-create', compact('outlets')),
            'title' => 'Tambah Hutang',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
            ]
        );
    }

    public function store(Request $request){
        $request->validate([
            'outlet' => 'required|exists:outlet,id',
            'nama_pemberi_hutang' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date_format:m/d/Y',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $tanggal = Carbon::createFromFormat('m/d/Y', $request->tanggal)->startOfDay();
        $hutang = new Hutang();
        $hutang->outlet_id = $request->outlet;
        $hutang->nama_pemberi_hutang = $request->nama_pemberi_hutang;
        $hutang->jumlah = $request->jumlah;
        $hutang->tanggal_hutang = $tanggal;
        $hutang->deskripsi = $request->deskripsi;
        $hutang->created_by = auth()->user()->id;
        $hutang->save();
        echo 'saved';
        return redirect()->route('keuangan.hutang.index')->with('success', 'Hutang berhasil ditambahkan.');
    }

    public function edit($id, Request $request)
    {
        $hutang = Hutang::findOrFail($id);
        $hutang->tanggal_hutang = $hutang->tanggal_hutang ? Carbon::parse($hutang->tanggal_hutang)->format('m/d/Y') : null;
        $outlets = Outlet::all();
        if ($request->ajax()) {
            return view('keuangan.hutang-edit', compact('hutang', 'outlets'));
        }
        return view('layouts.admin', [
            'slot' => view('keuangan.hutang-edit', compact('hutang', 'outlets')),
            'title' => 'Edit Hutang',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'outlet' => 'required|exists:outlet,id',
            'nama_pemberi_hutang' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date_format:m/d/Y',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $hutang = Hutang::findOrFail($id);
        $hutang->outlet_id = $request->outlet;
        $hutang->nama_pemberi_hutang = $request->nama_pemberi_hutang;
        $hutang->jumlah = $request->jumlah;
        $hutang->tanggal_hutang = Carbon::createFromFormat('m/d/Y', $request->tanggal)->startOfDay();
        $hutang->deskripsi = $request->deskripsi;
        $hutang->save();

        return redirect()->route('keuangan.hutang.index')->with('success', 'Hutang berhasil diperbarui.');
    }

    public function destroy($id, Request $request){
        $hutang = Hutang::findOrFail($id);
        $hutang->delete();

        return redirect()->route('keuangan.hutang.index')->with('success', 'Hutang berhasil dihapus.');
      
    }
}
