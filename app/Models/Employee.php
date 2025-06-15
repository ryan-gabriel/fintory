<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $table = 'employee';

    protected $fillable = [
        'user_id',
        'name',
        'outlet_id',
        'lembaga_id',
        'position',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'date',
    ];

    /**
     * Get the user that owns the employee.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the outlet that owns the employee.
     */
    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }

    /**
     * Get the lembaga that owns the employee.
     */
    public function lembaga(): BelongsTo
    {
        return $this->belongsTo(Lembaga::class);
    }
}