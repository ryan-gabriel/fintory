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
     */
    public function balance(): HasOne
    {
        return $this->hasOne(OutletBalance::class, 'outlet_id', 'id')->withDefault([
            'balance' => 0
        ]);
    }

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
