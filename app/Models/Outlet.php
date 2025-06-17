<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Outlet extends Model
{
    use HasFactory;

    protected $table = 'outlet';
    protected $guarded = ['id'];

<<<<<<< HEAD
    /**
     * Relasi ke lembaga (many-to-one)
     *
     * @return BelongsTo
     */
    public function lembaga(): BelongsTo
    {
        return $this->belongsTo(Lembaga::class);
    }

    /**
     * Relasi one-to-one ke OutletBalance
     * 
     * @return HasOne
=======
    // ... relasi lain ...

    /**
     * Relasi one-to-one ke OutletBalance.
>>>>>>> 7b2aac43a16d8fa7e4b763745a9dd35dde0fe836
     */
    public function balance(): HasOne
    {
        return $this->hasOne(OutletBalance::class, 'outlet_id', 'id')->withDefault([
            'saldo' => 0,
            'last_updated' => now(), // Memberikan nilai default untuk last_updated
        ]);
    }
<<<<<<< HEAD

    /**
     * Produk yang dimiliki outlet ini.
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Penjualan di outlet ini.
     *
     * @return HasMany
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Mutasi stok di outlet ini.
     *
     * @return HasMany
     */
    public function stockMutations(): HasMany
    {
        return $this->hasMany(StockMutation::class);
    }

    /**
     * Hutang terkait outlet ini.
     *
     * @return HasMany
     */
    public function hutang(): HasMany
    {
        return $this->hasMany(Hutang::class);
    }

    /**
     * Pegawai yang bekerja di outlet ini.
     *
     * @return HasMany
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * Relasi ke pencatatan kas outlet ini (cash ledger)
     *
     * @return HasMany
     */
    public function cashLedgers(): HasMany
    {
        return $this->hasMany(CashLedger::class);
    }
}
=======
    
    // ... relasi lain seperti products, sales, dll. ...
    public function products(): HasMany { return $this->hasMany(Product::class); }
    public function sales(): HasMany { return $this->hasMany(Sale::class); }
    public function stockMutations(): HasMany { return $this->hasMany(StockMutation::class); }
    public function hutang(): HasMany { return $this->hasMany(Hutang::class); }
    public function employees(): HasMany { return $this->hasMany(Employee::class); }
}
>>>>>>> 7b2aac43a16d8fa7e4b763745a9dd35dde0fe836
