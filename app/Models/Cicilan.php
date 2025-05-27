<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cicilan extends Model
{
    use HasFactory;

    protected $table = 'cicilan';

    protected $fillable = [
        'hutang_id',
        'tanggal_bayar',
        'jumlah_bayar',
        'metode_pembayaran',
        'deskripsi',
        'created_by',
    ];

    public function hutang()
    {
        return $this->belongsTo(Hutang::class, 'hutang_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
