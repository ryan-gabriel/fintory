<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lembaga extends Model
{
    // Override the default "lembagas" table name
    protected $table = 'lembaga';

    // If your primary key is "id" you don't need to change anything else.
    // Add any fillable/hidden/etc. as needed:
    protected $fillable = [
        'name',
        'industry',
        'phone',
        'email',
        'address',
        'logo_path',
    ];
    
    // … fillable, timestamps, etc.

    /**
     * Get the subscription status for this lembaga.
     */
    public function subscriptionStatus(): HasOne
    {
        return $this->hasOne(SubscriptionStatus::class);
    }

    /**
     * Which users participate in this lembaga, and what role they have.
     */
    public function usersWithRoles()
    {
        return $this
            ->belongsToMany(
                User::class,
                'lembaga_user_role',
                'lembaga_id',
                'user_id'
            )
            ->withPivot('role_id')
            ->withTimestamps();
    }

    /**
     * Which roles exist in this lembaga (and which user holds them):
     */
    public function rolesForUsers()
    {
        return $this
            ->belongsToMany(
                Role::class,
                'lembaga_user_role',
                'lembaga_id',
                'role_id'
            )
            ->withPivot('user_id')
            ->withTimestamps();
    }

    /**
     * Get admin users for this lembaga
     */
    public function admins()
    {
        return $this->usersWithRoles()
            ->whereHas('lembagaRoles', function ($query) {
                $query->where('role_name', 'admin')
                      ->wherePivot('lembaga_id', $this->id);
            });
    }

    /**
     * Check if lembaga has active subscription
     */
    public function hasActiveSubscription()
    {
        return $this->subscriptionStatus && $this->subscriptionStatus->isActive();
    }
}
