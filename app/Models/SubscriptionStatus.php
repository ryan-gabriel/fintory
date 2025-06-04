<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionStatus extends Model
{
    protected $table = 'subscription_status';

    protected $fillable = [
        'lembaga_id',
        'status',
        'tier',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the lembaga that owns this subscription.
     */
    public function lembaga(): BelongsTo
    {
        return $this->belongsTo(Lembaga::class);
    }

    /**
     * Check if subscription is currently active
     */
    public function isActive(): bool
    {
        return $this->is_active &&
            $this->status === 'active' || $this->status === 'trial' &&
            ($this->end_date === null || $this->end_date->isFuture());
    }

    /**
     * Check if subscription is trial
     */
    public function isTrial(): bool
    {
        return $this->status === 'trial';
    }
}