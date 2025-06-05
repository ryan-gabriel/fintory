<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';

    protected $fillable = [
        'user_id',
        'name',
        'outlet_id',
        'lembaga_id',
        'position',
        'joined_at',
    ];

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Outlet.
     */
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    /**
     * Relasi ke model Lembaga.
     */
    public function lembaga()
    {
        return $this->belongsTo(Lembaga::class);
    }
}
