<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * Get menu hierarchy
     */
    public static function getMenuHierarchy()
    {
        return self::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->orderBy('order');
            }])
            ->get();
    }
}