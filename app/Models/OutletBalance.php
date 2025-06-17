<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletBalance extends Model
{
    use HasFactory;

    protected $table = 'outletbalance';

    /**
     * Primary key untuk tabel ini adalah 'outlet_id'.
     *
     * @var string
     */
    protected $primaryKey = 'outlet_id';

    /**
     * Karena primary key bukan auto-incrementing, set properti ini ke false.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'outlet_id',
        'saldo',
        'last_updated',
    ];

    /**
     * Mendefinisikan relasi ke model Outlet.
     */
    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id', 'id');
    }
}