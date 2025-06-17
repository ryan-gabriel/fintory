<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletBalance extends Model
{
    use HasFactory;

    protected $table = 'outletbalance';
    protected $guarded = ['id'];
    
    // Primary key tabel ini adalah 'id', bukan 'outlet_id'
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * Mendefinisikan relasi ke model Outlet. (VERSI PERBAIKAN)
     */
    public function outlet()
    {
        // Secara eksplisit mendefinisikan foreign key dan owner key
        // Foreign Key: 'outlet_id' di tabel ini
        // Owner Key: 'id' di tabel outlet
        return $this->belongsTo(Outlet::class, 'outlet_id', 'id');
    }
}