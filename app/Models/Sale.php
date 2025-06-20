<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sale';

    protected $fillable = [
        'outlet_id',
        'customer_name',
        'sale_date',
        'total',
        'created_by',
    ];

    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class, 'sale_id');
    }

    protected static function booted()
    {
        static::created(function ($sale) {
            $lembagaId = session('current_lembaga_id');
            if (!$lembagaId) return;

            $outletName = optional($sale->outlet)->name ?? 'Outlet Tidak Diketahui';
            $creator = optional($sale->creator)->email ?? 'Unknown';

            LogAktivitas::create([
                'lembaga_id' => $lembagaId,
                'pesan' => "[SALE][CREATE] Oleh {$creator}. Pelanggan: {$sale->customer_name}, Outlet: {$outletName}, Total: Rp " . number_format($sale->total, 0, ',', '.') . ", Tanggal: " . optional($sale->sale_date)->format('Y-m-d'),
            ]);
        });
    }
}