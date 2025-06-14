<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     * @var string
     */
    protected $table = 'product';

    /**
     * Atribut yang bisa diisi secara massal.
     * @var array
     */
    protected $fillable = [
        'outlet_id',
        'barang_id',
        'kategori_id',
        'harga_jual',
        'stok',
        'is_active',
    ];

    /**
     * Relasi ke model Barang.
     * Karena primary key di tabel 'barang' adalah 'kode_barang', kita perlu menentukannya.
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'kode_barang');
    }

    /**
     * Relasi ke model Kategori.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Relasi ke model Outlet.
     */
    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }
}