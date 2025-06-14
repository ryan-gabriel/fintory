<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     * @var string
     */
    protected $table = 'kategori';

    /**
     * Atribut yang bisa diisi secara massal.
     * @var array
     */
    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    /**
     * Relasi ke produk yang memiliki kategori ini.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'kategori_id');
    }
}