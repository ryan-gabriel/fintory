<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Session;
use App\Models\LogAktivitas;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'outlet_id',
        'barang_id',
        'kategori_id',
        'harga_jual',
        'stok',
        'is_active',
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'kode_barang');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }

    protected static function booted()
    {
        static::created(function ($product) {
            $lembagaId = session('current_lembaga_id');
            if (!$lembagaId) return;

            $namaBarang = optional($product->barang)->nama ?? 'Barang Tidak Diketahui';
            $outletName = optional($product->outlet)->name ?? 'Outlet Tidak Diketahui';

            LogAktivitas::create([
                'lembaga_id' => $lembagaId,
                'pesan' => "[PRODUCT][CREATE] Produk: {$namaBarang}, Outlet: {$outletName}, Harga: Rp " . number_format($product->harga_jual, 0, ',', '.') . ", Stok: {$product->stok}",
            ]);
        });

        static::updated(function ($product) {
            $lembagaId = session('current_lembaga_id');
            if (!$lembagaId) return;

            $namaBarang = optional($product->barang)->nama ?? 'Barang Tidak Diketahui';
            $outletName = optional($product->outlet)->name ?? 'Outlet Tidak Diketahui';
            $original = $product->getOriginal();

            $log = "[PRODUCT][UPDATE] Produk: {$namaBarang}, Outlet: {$outletName}";

            if ($product->harga_jual != $original['harga_jual']) {
                $log .= ", Harga: Rp " . number_format($original['harga_jual'], 0, ',', '.') . " → Rp " . number_format($product->harga_jual, 0, ',', '.');
            }
            if ($product->stok != $original['stok']) {
                $log .= ", Stok: {$original['stok']} → {$product->stok}";
            }
            if ($product->is_active != $original['is_active']) {
                $statusLama = $original['is_active'] ? 'Aktif' : 'Nonaktif';
                $statusBaru = $product->is_active ? 'Aktif' : 'Nonaktif';
                $log .= ", Status: {$statusLama} → {$statusBaru}";
            }

            LogAktivitas::create([
                'lembaga_id' => $lembagaId,
                'pesan' => $log,
            ]);
        });

        static::deleted(function ($product) {
            $lembagaId = session('current_lembaga_id');
            if (!$lembagaId) return;

            $namaBarang = optional($product->barang)->nama ?? 'Barang Tidak Diketahui';
            $outletName = optional($product->outlet)->name ?? 'Outlet Tidak Diketahui';

            LogAktivitas::create([
                'lembaga_id' => $lembagaId,
                'pesan' => "[PRODUCT][DELETE] Produk: {$namaBarang}, Outlet: {$outletName}, Harga: Rp " . number_format($product->harga_jual, 0, ',', '.') . ", Stok: {$product->stok}",
            ]);
        });
    }
}
