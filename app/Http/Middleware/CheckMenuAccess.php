<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckMenuAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip check for non-authenticated users
        if (!auth()->check()) {
            return $next($request);
        }

        // Get current user's role from session
        $currentRoleId = session('current_role_id');
        
        if (!$currentRoleId) {
            return redirect()->route('auth.choose_role');
        }

        // Get current route name
        $currentRoute = '/' . $request->path();
        
        // Create cache key for this role's accessible routes
        $cacheKey = "menu_access_role_{$currentRoleId}";
        
        // Get accessible routes from cache or database
        $accessibleRoutes = Cache::remember($cacheKey, 86400, function () use ($currentRoleId) {
            return MenuItem::whereNotNull('route')
                ->where('is_active', true)
                ->whereHas('roles', function ($query) use ($currentRoleId) {
                    $query->where('role_id', $currentRoleId);
                })
                ->pluck('route')
                ->toArray();
        });
        
        // Check if current route is accessible
        $hasAccess = $this->checkRouteAccess($currentRoute, $accessibleRoutes);

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }

    /**
     * Check if current route has access based on accessible routes
     */
    private function checkRouteAccess(string $currentRoute, array $accessibleRoutes): bool
    {

        foreach ($accessibleRoutes as $menuRoute) {
            // Exact match
            if ($menuRoute === $currentRoute) {
                return true;
            }

            // Parameterized route
            if (strpos($menuRoute, '{') !== false) {
                $pattern = str_replace(['{', '}'], ['[^/]+', ''], $menuRoute);
                $pattern = '#^' . str_replace('/', '\/', $pattern) . '$#';

                if (preg_match($pattern, $currentRoute)) {
                    return true;
                }
            }

            // Prefix match
            if (strpos($currentRoute, $menuRoute) === 0) {
                return true;
            }

        }

        return false;
    }


    /**
     * Clear cache for specific role (useful when menu items are updated)
     */
    public static function clearRoleCache(int $roleId): void
    {
        \App\Models\MenuItem::clearRoleCache($roleId);
    }

    /**
     * Clear all menu access cache (useful when updating multiple roles)
     */
    public static function clearAllCache(): void
    {
        \App\Models\MenuItem::clearAllMenuCache();
    }
}