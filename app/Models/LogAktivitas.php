<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'log_aktivitas';

    protected $fillable = [
        'lembaga_id',
        'pesan',
        'created_at',
        'updated_at',
    ];

    public function lembaga()
    {
        return $this->belongsTo(Lembaga::class);
    }
}
