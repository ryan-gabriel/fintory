<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_name',
        'icon',
        'route',
        'is_parent',
        'parent_id',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_parent' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Cache TTL in seconds (1 hour)
    const CACHE_TTL = 3600;

    /**
     * Get the parent menu item
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Get the child menu items
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    /**
     * Get the roles that can access this menu item
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'menu_roles', 'menu_item_id', 'role_id')
            ->withTimestamps();
    }

    /**
     * Scope to get only parent menus
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id')->orderBy('order');
    }

    /**
     * Scope to get only active menus
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get menus accessible by specific role
     */
    public function scopeAccessibleByRole($query, $roleId)
    {
        return $query->whereHas('roles', function ($q) use ($roleId) {
            $q->where('role_id', $roleId);
        });
    }

    /**
     * Get menu hierarchy filtered by role with Redis caching
     */
    public static function getMenuHierarchyByRole($roleId)
    {
        $cacheKey = "menu_hierarchy_role_{$roleId}";
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($roleId) {
            return self::active()
                ->accessibleByRole($roleId)
                ->parents()
                ->with(['children' => function ($query) use ($roleId) {
                    $query->active()
                        ->accessibleByRole($roleId)
                        ->orderBy('order');
                }])
                ->get()
                ->filter(function ($menu) {
                    // Keep parent menus that either have accessible children or are accessible themselves
                    return $menu->children->count() > 0 || $menu->roles->count() > 0;
                });
        });
    }   

    /**
     * Get menu hierarchy (original method for backward compatibility) with caching
     */
    public static function getMenuHierarchy()
    {
        // Get current user's role from session
        $currentRoleId = session('current_role_id');
        
        if ($currentRoleId) {
            return self::getMenuHierarchyByRole($currentRoleId);
        }

        // Fallback to all menus with cache
        $cacheKey = "menu_hierarchy_all";
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            return self::active()
                ->parents()
                ->with(['children' => function ($query) {
                    $query->active()->orderBy('order');
                }])
                ->get();
        });
    }

    /**
     * Clear cache for specific role
     */
    public static function clearRoleCache($roleId = null): void
    {
        if ($roleId) {
            Cache::forget("menu_hierarchy_role_{$roleId}");
        } else {
            // Clear cache for all roles
            $roles = \App\Models\Role::all();
            foreach ($roles as $role) {
                Cache::forget("menu_hierarchy_role_{$role->id}");
            }
            Cache::forget("menu_hierarchy_all");
        }
    }

    /**
     * Clear all menu caches
     */
    public static function clearAllMenuCache(): void
    {
        // Get all role IDs and clear their caches
        $roles = \App\Models\Role::all();
        foreach ($roles as $role) {
            Cache::forget("menu_hierarchy_role_{$role->id}");
        }
        Cache::forget("menu_hierarchy_all");
    }

    /**
     * Boot method to handle cache invalidation on model events
     */
    protected static function boot()
    {
        parent::boot();

        // Clear cache when menu items are created, updated, or deleted
        static::created(function () {
            self::clearAllMenuCache();
        });

        static::updated(function () {
            self::clearAllMenuCache();
        });

        static::deleted(function () {
            self::clearAllMenuCache();
        });
    }

    /**
     * Check if menu is accessible by role
     */
    public function isAccessibleByRole($roleId): bool
    {
        return $this->roles()->where('role_id', $roleId)->exists();
    }
}