<?php

namespace App\Http\Controllers;

use App\Models\CashLedger;
use Illuminate\Http\Request;

class KasLedgerController extends Controller
{
    public function index(Request $request){
        $cashLedger = CashLedger::with(['outlet'])
            ->orderBy('tanggal', 'desc')
            ->get();
      
        if ($request->ajax()) {
            return view('kas-ledger', compact('cashLedger'));
        }
        return view('layouts.admin', [
            'title' => 'Kas & Ledger',
            'slot' => view('kas-ledger', [
                'cashLedger' => $cashLedger,
            ]),
        ]);
    }

    public function create(){
        return view('');
    }
    
    public function store(){
        return view('kas-ledger');
    }
}
