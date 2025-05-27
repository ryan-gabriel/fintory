<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashLedger extends Model
{
    use HasFactory;

    protected $table = 'cashledger';

    protected $fillable = [
        'outlet_id',
        'tanggal',
        'tipe',
        'sumber',
        'referensi_id',
        'deskripsi',
        'amount',
        'saldo_setelah',
        'created_by',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
