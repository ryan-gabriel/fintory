<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $table = 'outlet';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'lembaga_id',
    ];

    public function owner()
    {
        return $this->belongsTo(Lembaga::class, 'lembaga_id');
    }

    public function balance()
    {
        return $this->hasOne(OutletBalance::class, 'outlet_id');
    }

    public function cashLedgers()
    {
        return $this->hasMany(CashLedger::class, 'outlet_id');
    }

    public function hutangs()
    {
       return $this->hasMany(Hutang::class, 'outlet_id');
    }
}
