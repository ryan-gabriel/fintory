<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', // Added name back to fillable
        'email',
        'password',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Many‐to‐many relationship with Role, but scoped by Lembaga.
     *
     * We'll call this "lembagaRoles" for clarity: it returns Role models
     * with a pivot 'lembaga_id'.
     */
    public function lembagaRoles()
    {
        return $this
            ->belongsToMany(
                Role::class,
                'lembaga_user_role', // pivot table name
                'user_id', // this model's FK
                'role_id' // related model's FK
            )
            ->withPivot('lembaga_id')
            ->withTimestamps();
    }

    /**
     * If you want to see which lembaga the user is in (regardless of role), you can also do:
     */
    public function lembagas()
    {
        return $this
            ->belongsToMany(
                Lembaga::class,
                'lembaga_user_role',
                'user_id',
                'lembaga_id'
            )
            ->withPivot('role_id')
            ->withTimestamps();
    }

    /**
     * Helper: get all roles for a given lembaga_id
     */
    public function rolesInLembaga($lembagaId)
    {
        return $this->lembagaRoles()
            ->wherePivot('lembaga_id', $lembagaId)
            ->get();
    }

    // Helper

    /**
     * Get the current lembaga ID from session
     */
    public function getCurrentLembagaId()
    {
        return session('current_lembaga_id');
    }

    /**
     * Get the current role ID from session
     */
    public function getCurrentRoleId()
    {
        return session('current_role_id');
    }

    /**
     * Get the current lembaga model
     */
    public function getCurrentLembaga()
    {
        $lembagaId = $this->getCurrentLembagaId();
        return $lembagaId ? Lembaga::find($lembagaId) : null;
    }

    /**
     * Get the current role model
     */
    public function getCurrentRole()
    {
        $roleId = $this->getCurrentRoleId();
        return $roleId ? Role::find($roleId) : null;
    }

    /**
     * Check if user has any roles assigned
     */
    public function hasAnyRole()
    {
        return $this->lembagaRoles()->exists();
    }

    /**
     * Get admin users for this lembaga
     */
    public function isAdminInLembaga($lembagaId)
    {
        return $this->lembagaRoles()
            ->where('role_name', 'admin')
            ->wherePivot('lembaga_id', $lembagaId)
            ->exists();
    }

    /**
     * Get user role in specific lembaga
     */
    public function getRoleInLembaga($lembagaId)
    {
        return $this->lembagaRoles()
            ->wherePivot('lembaga_id', $lembagaId)
            ->first();
    }

    /**
     * Get the employee records for the user.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * Get employee in specific lembaga
     */
    public function getEmployeeInLembaga($lembagaId)
    {
        return $this->employees()->where('lembaga_id', $lembagaId)->first();
    }

    /**
     * Get employee name in current lembaga
     */
    public function getNameInLembaga($lembagaId)
    {
        $employee = $this->getEmployeeInLembaga($lembagaId);
        return $employee ? $employee->name : $this->email;
    }
}
