<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use App\Models\LogAktivitas;

class CashLedger extends Model
{
    use HasFactory;

    protected $table = 'cashledger';

    protected $fillable = [
        'outlet_id',
        'tanggal',
        'tipe',
        'sumber',
        'referensi_id',
        'deskripsi',
        'amount',
        'saldo_setelah',
        'created_by',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function booted()
    {
        static::created(function ($ledger) {
            $lembagaId = session('current_lembaga_id');

            if (!$lembagaId || !$ledger->created_by) {
                return;
            }

            $email = optional($ledger->creator)->email ?? 'Unknown';
            $tanggal = optional($ledger->tanggal)->format('Y-m-d');
            $outletName = optional($ledger->outlet)->name ?? 'Outlet Tidak Diketahui';

            LogAktivitas::create([
                'lembaga_id' => $lembagaId,
                'pesan' => "[CASHLEDGER][CREATE] Oleh {$email}. Outlet: {$outletName}, Tanggal: {$tanggal}, Jumlah: Rp " . number_format($ledger->amount, 0, ',', '.') . ", Deskripsi: {$ledger->deskripsi}",
            ]);
        });

        static::updated(function ($ledger) {
            $lembagaId = session('current_lembaga_id');

            if (!$lembagaId || !$ledger->created_by) {
                return;
            }

            $email = optional($ledger->creator)->email ?? 'Unknown';
            $original = $ledger->getOriginal();
            $outletName = optional($ledger->outlet)->name ?? 'Outlet Tidak Diketahui';

            $log = "[CASHLEDGER][UPDATE] Oleh {$email}. ID: {$ledger->id}, Outlet: {$outletName}";
            if ($ledger->amount != $original['amount']) {
                $log .= ", Jumlah: Rp " . number_format($original['amount'], 0, ',', '.') . " → Rp " . number_format($ledger->amount, 0, ',', '.');
            }
            if ($ledger->deskripsi != $original['deskripsi']) {
                $log .= ", Deskripsi: '{$original['deskripsi']}' → '{$ledger->deskripsi}'";
            }

            LogAktivitas::create([
                'lembaga_id' => $lembagaId,
                'pesan' => $log,
            ]);
        });

        static::deleted(function ($ledger) {
            $lembagaId = session('current_lembaga_id');

            if (!$lembagaId || !$ledger->created_by) {
                return;
            }

            $email = optional($ledger->creator)->email ?? 'Unknown';
            $tanggal = optional($ledger->tanggal)->format('Y-m-d');
            $outletName = optional($ledger->outlet)->name ?? 'Outlet Tidak Diketahui';

            LogAktivitas::create([
                'lembaga_id' => $lembagaId,
                'pesan' => "[CASHLEDGER][DELETE] Oleh {$email}. ID: {$ledger->id}, Outlet: {$outletName}, Tanggal: {$tanggal}, Jumlah: Rp " . number_format($ledger->amount, 0, ',', '.') . ", Deskripsi: {$ledger->deskripsi}",
            ]);
        });
    }

}
