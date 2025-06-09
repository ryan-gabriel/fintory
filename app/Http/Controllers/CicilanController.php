<?php

namespace App\Http\Controllers;

use App\Models\Cicilan;
use App\Models\Hutang;
use App\Models\Lembaga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CicilanController extends Controller
{
    public function getData(Request $request){
        $columns = [
            0 => 'tanggal_bayar',
            1 => 'hutang.nama_pemberi_hutang',
            2 => 'jumlah_bayar',
            3 => 'hutang.sisa_hutang',
            4 => 'metode_pembayaran',
        ];

        $query = Cicilan::with(['hutang.outlet']);

        if ($request->filled('start_date')) {
            try {
                $startDate = Carbon::createFromFormat('m/d/Y', $request->start_date)->startOfDay();
                $query->where('tanggal_bayar', '>=', $startDate);
            } catch (\Exception $e) {
                Log::warning('Invalid start_date format: ' . $request->start_date);
            }
        }

        if ($request->filled('end_date')) {
            try {
                $endDate = Carbon::createFromFormat('m/d/Y', $request->end_date)->endOfDay();
                $query->where('tanggal_bayar', '<=', $endDate);
            } catch (\Exception $e) {
                Log::warning('Invalid end_date format: ' . $request->end_date);
            }
        }

        // Total sebelum filter
        $totalData = Cicilan::count();

        // Search filter
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

        // Total setelah filter
        $totalFiltered = $query->count();

        // Sorting
        $orderColIndex = $request->input('order.0.column', 4);
        $orderDir = strtolower($request->input('order.0.dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        $orderCol = $columns[$orderColIndex] ?? 'tanggal_bayar';

        if ($orderCol === 'hutang.nama_pemberi_hutang') {
            $query->join('hutang', 'hutang.id', '=', 'cicilan.hutang_id')
                ->orderBy('hutang.nama_pemberi_hutang', $orderDir)
                ->select('cicilan.*');
        } elseif ($orderCol === 'hutang.sisa_hutang') {
            $query->join('hutang', 'hutang.id', '=', 'cicilan.hutang_id')
                ->orderBy('hutang.sisa_hutang', $orderDir)
                ->select('cicilan.*');
        } elseif ($orderCol === 'outlet.name') {
            $query->join('hutang', 'hutang.id', '=', 'cicilan.hutang_id')
                ->join('outlet', 'outlet.id', '=', 'hutang.outlet_id')
                ->orderBy('outlet.name', $orderDir)
                ->select('cicilan.*');
        } else {
            $query->orderBy($orderCol, $orderDir);
        }

        // Pagination
        $start = max(0, intval($request->input('start', 0)));
        $length = max(1, intval($request->input('length', 10)));
        $data = $query->skip($start)->take($length)->get();

        // Format JSON
        $jsonData = [
            "draw" => intval($request->input('draw', 1)),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data" => [],
        ];

        foreach ($data as $row) {
            $jsonData['data'][] = [
                $row->tanggal_bayar ? date('d-m-Y', strtotime($row->tanggal_bayar)) : '-',
                $row->hutang->nama_pemberi_hutang ?? '-',
                'Rp ' . number_format($row->jumlah_bayar ?? 0, 0, ',', '.'),
                'Rp ' . number_format($row->hutang->sisa_hutang ?? 0, 0, ',', '.'),
                $row->metode_pembayaran ?? '-',
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
}
