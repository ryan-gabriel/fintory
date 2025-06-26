<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\MenuItem;
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
        $currentRoute = $request->route()->getName();
        
        // Check if current route is accessible by user's role
        $hasAccess = MenuItem::whereNotNull('route')
            ->where('is_active', true)
            ->whereHas('roles', function ($query) use ($currentRoleId) {
                $query->where('role_id', $currentRoleId);
            })
            ->get()
            ->contains(function ($menuItem) use ($currentRoute) {
                $menuRoute = $menuItem->route;
                
                // Handle exact match
                if ($menuRoute === $currentRoute) {
                    return true;
                }
                
                // Handle routes with wildcards or parameters
                if (strpos($menuRoute, '{') !== false) {
                    // Convert route pattern to regex
                    $pattern = str_replace(['{', '}'], ['[^/]+', ''], $menuRoute);
                    $pattern = '#^' . str_replace('/', '\/', $pattern) . '$#';
                    return preg_match($pattern, $currentRoute);
                }
                
                // Handle route prefixes (for grouped routes)
                if (strpos($currentRoute, $menuRoute) === 0) {
                    return true;
                }
                
                return false;
            });

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}