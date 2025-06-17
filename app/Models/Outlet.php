<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Outlet extends Model
{
    use HasFactory;

    protected $table = 'outlet';
    protected $guarded = ['id'];

    /**
     * Relasi ke Lembaga.
     */
    public function lembaga()
    {
        return $this->belongsTo(Lembaga::class);
    }

    /**
     * Relasi one-to-one ke OutletBalance. (VERSI PERBAIKAN)
     */
    public function balance()
    {
        // Secara eksplisit mendefinisikan foreign key dan local key
        // Foreign Key: 'outlet_id' di tabel outletbalance
        // Local Key: 'id' di tabel outlet ini sendiri
        return $this->hasOne(OutletBalance::class, 'outlet_id', 'id')->withDefault([
            'balance' => 0
        ]);
    }

    // Relasi lain yang dibutuhkan (biarkan seperti ini)
    public function products(): HasMany { return $this->hasMany(Product::class); }
    public function sales(): HasMany { return $this->hasMany(Sale::class); }
    public function stockMutations(): HasMany { return $this->hasMany(StockMutation::class); }
    public function hutang(): HasMany { return $this->hasMany(Hutang::class); }
    public function employees(): HasMany { return $this->hasMany(Employee::class); }
}