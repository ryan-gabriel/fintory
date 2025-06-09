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
            $jsonData['data'][] = [
                $row->tanggal_hutang ? date('d-m-Y', strtotime($row->tanggal_hutang)) : '-',
                $row->outlet->name ?? '-',
                $row->nama_pemberi_hutang ?? '-',
                'Rp ' . number_format($row->jumlah, 0, ',', '.'),
                'Rp ' . number_format($row->sisa_hutang, 0, ',', '.'),
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

    public function store(){

    }
}
