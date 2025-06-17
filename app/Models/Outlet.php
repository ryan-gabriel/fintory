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

    // ... relasi lain ...

    /**
     * Relasi one-to-one ke OutletBalance.
     */
    public function balance()
    {
        return $this->hasOne(OutletBalance::class, 'outlet_id', 'id')->withDefault([
            'saldo' => 0,
            'last_updated' => now(), // Memberikan nilai default untuk last_updated
        ]);
    }
    
    // ... relasi lain seperti products, sales, dll. ...
    public function products(): HasMany { return $this->hasMany(Product::class); }
    public function sales(): HasMany { return $this->hasMany(Sale::class); }
    public function stockMutations(): HasMany { return $this->hasMany(StockMutation::class); }
    public function hutang(): HasMany { return $this->hasMany(Hutang::class); }
    public function employees(): HasMany { return $this->hasMany(Employee::class); }
}