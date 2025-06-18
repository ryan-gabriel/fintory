<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class LogAktivitasController extends Controller
{
    public function getData(Request $request)
    {
        $columns = [
            0 => 'created_at',
            1 => 'pesan',
        ];

        $currentLembagaId = session('current_lembaga_id');

        $query = LogAktivitas::where('lembaga_id', $currentLembagaId);

        if ($request->filled('start_date')) {
            try {
                $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date)->startOfDay();
                $query->where('created_at', '>=', $startDate);
            } catch (\Exception $e) {
                Log::warning('Invalid start_date format: ' . $request->start_date);
            }
        }

        if ($request->filled('end_date')) {
            try {
                $endDate = Carbon::createFromFormat('d-m-Y', $request->end_date)->endOfDay();
                $query->where('created_at', '<=', $endDate);
            } catch (\Exception $e) {
                Log::warning('Invalid end_date format: ' . $request->end_date);
            }
        }

        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where('pesan', 'like', "%{$search}%");
        }

        $totalData = LogAktivitas::where('lembaga_id', $currentLembagaId)->count();
        $totalFiltered = $query->count();

        $orderColIndex = $request->input('order.0.column', 0);
        $orderDir = strtolower($request->input('order.0.dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        $orderCol = $columns[$orderColIndex] ?? 'created_at';

        $query->orderBy($orderCol, $orderDir);

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
                $row->created_at ? date('d-m-Y H:i:s', strtotime($row->created_at)) : '-',
                $row->pesan,
            ];
        }

        return response()->json($jsonData);
    }

    public function index(Request $request)
    {
        $logs = LogAktivitas::where('lembaga_id', session('current_lembaga_id'))
            ->orderBy('created_at', 'desc')->get();

        if ($request->ajax()) {
            return view('log_aktivitas.index', compact('logs'));
        }

        return view('layouts.admin', [
            'slot' => view('log_aktivitas.index', compact('logs')),
            'title' => 'Log Aktivitas',
            'lembaga' => \App\Models\Lembaga::find(session('current_lembaga_id')),
        ]);
    }
}
