<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'role_name',
        'display_name',
        'description',
    ];

    /**
     * Many‐to‐many back to User, with lembaga pivot.
     */
    public function usersInLembaga()
    {
        return $this
            ->belongsToMany(
                User::class,
                'lembaga_user_role',
                'role_id',
                'user_id'
            )
            ->withPivot('lembaga_id')
            ->withTimestamps();
    }

    /**
     * If you want to see which lembaga grant this role:
     */
    public function lembagas()
    {
        return $this
            ->belongsToMany(
                Lembaga::class,
                'lembaga_user_role',
                'role_id',
                'lembaga_id'
            )
            ->withPivot('user_id')
            ->withTimestamps();
    }

    /**
     * Get users with this role in a specific lembaga
     */
    public function usersInSpecificLembaga($lembagaId)
    {
        return $this->usersInLembaga()
            ->wherePivot('lembaga_id', $lembagaId);
    }
}