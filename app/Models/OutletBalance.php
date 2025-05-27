<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletBalance extends Model
{
    use HasFactory;

    protected $table = 'outletbalance';

    protected $primaryKey = 'outlet_id'; // karena primary key bukan 'id'
    public $incrementing = false;

    protected $fillable = [
        'outlet_id',
        'saldo',
        'last_updated',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }
}
