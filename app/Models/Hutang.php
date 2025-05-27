<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    use HasFactory;

    protected $table = 'hutang';

    protected $fillable = [
        'outlet_id',
        'nama_pemberi_hutang',
        'tanggal_hutang',
        'jumlah',
        'sisa_hutang',
        'deskripsi',
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

    public function cicilan()
    {
        return $this->hasMany(Cicilan::class, 'hutang_id');
    }
}
