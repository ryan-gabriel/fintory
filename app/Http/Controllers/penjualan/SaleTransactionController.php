<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use Illuminate\Http\Request;

class SaleTransactionController extends Controller
{
    public function index()
    {
        return view('layouts.admin', [
            'slot' => view('penjualan.transaksi.index'),
            'title' => 'Transaksi Penjualan',
            'lembaga' => Lembaga::find(session('current_lembaga_id')),
        ]);
    }
}