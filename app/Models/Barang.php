<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     * @var string
     */
    protected $table = 'barang';

    /**
     * Primary key untuk tabel ini.
     * @var string
     */
    protected $primaryKey = 'kode_barang';

    /**
     * Tipe data dari primary key.
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Menunjukkan bahwa primary key tidak auto-incrementing jika namanya bukan 'id'.
     * Karena di migrasi Anda menggunakan increments('kode_barang'), maka ini true.
     * @var bool
     */
    public $incrementing = true;

    /**
     * Atribut yang bisa diisi secara massal (mass assignable).
     * @var array
     */
    protected $fillable = [
        'nama',
        'deskripsi',
    ];
}
