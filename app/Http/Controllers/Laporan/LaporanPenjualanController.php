<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use App\Models\Sale;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LaporanPenjualanController extends Controller
{
    /**
     * Menampilkan halaman utama Laporan Penjualan.
     */
    public function index(Request $request)
    {
        // Cek jika request datang dari AJAX (navigasi internal)
        if ($request->ajax()) {
            return view('laporan.penjualan.index');
        }

        // Jika request biasa (load halaman penuh)
        return view('layouts.admin', [
            'slot' => view('laporan.penjualan.index'),
            'title' => 'Laporan Penjualan',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }

    /**
     * Menyediakan data untuk DataTables dengan filter tanggal.
     */
    public function getData(Request $request)
    {
        // Mulai query ke model Sale dengan relasi yang dibutuhkan
        $query = Sale::with(['outlet', 'creator']);

        // Hapus filter tanggal individual, karena filter rentang tanggal sudah ada di bawah
        // Tidak perlu filter created_at, gunakan sale_date sesuai filter rentang tanggal di bawah

        // Terapkan filter rentang tanggal jika ada
        if ($request->filled('start_date')) {
            $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date)->startOfDay();
            if ($request->filled('end_date')) {
                $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date)->endOfDay();
            } else {
                $endDate = now()->endOfDay();
            }
            $query->whereBetween('sale_date', [$startDate, $endDate]);
        } elseif ($request->filled('end_date')) {
            $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date)->endOfDay();
            $query->where('sale_date', '<=', $endDate);
        }

        // Terapkan filter pencarian
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%") // Cari berdasarkan ID transaksi
                    ->orWhereHas('outlet', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Ambil parameter sorting dari request DataTables
        $orderColIndex = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'desc');
        $columns = [
            0 => 'sale_date',
            1 => 'id',
            2 => 'outlet.name',
            3 => 'customer_name',
            4 => 'total',
        ];
        $orderCol = $columns[$orderColIndex] ?? 'sale_date';

        if ($orderCol === 'outlet.name') {
            $query->join('outlets', 'outlets.id', '=', 'sales.outlet_id')
                ->orderBy('outlets.name', $orderDir)
                ->select('sales.*'); // ensure sales.* is selected after join
        } else {
            $query->orderBy($orderCol, $orderDir);
        }

        $totalFiltered = $query->count();

        // Ambil data sesuai parameter DataTables (paging, sorting)
        $data = $query->latest()->offset($request->start)->limit($request->length)->get();

        $jsonData = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => Sale::count(),
            "recordsFiltered" => $totalFiltered,
            "data" => []
        ];

        foreach ($data as $sale) {
            $jsonData['data'][] = [
                \Carbon\Carbon::parse($sale->sale_date)->format('d M Y'),
                'TRX-' . str_pad($sale->id, 5, '0', STR_PAD_LEFT),
                $sale->outlet->name ?? 'N/A',
                $sale->customer_name,
                'Rp ' . number_format($sale->total, 0, ',', '.'),
                '<a href="' . route('penjualan.show', $sale->id) . '" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Detail</a>'
            ];
        }

        return response()->json($jsonData);
    }
}