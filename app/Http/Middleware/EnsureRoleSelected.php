<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRoleSelected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // If the user is not yet authenticated, just continue.
        if (! $request->user()) {
            return $next($request);
        }

        // Count how many (lembaga, role) combos this user has.
        $comboCount = $request->user()->lembagaRoles()->count();

        if ($comboCount === 0) {
            // No assignments at all → log out with error.
            auth()->logout();

            return redirect()->route('login')
                ->withErrors([
                    'auth' => 'You have no role assignment in any lembaga. ’Contact admin.’',
                ]);
        }

        // If they’ve already picked a combo this session, let them through.
        if ($request->session()->has('current_lembaga_id')
            && $request->session()->has('current_role_id')
        ) {
            return $next($request);
        }

        // If exactly one assignment, auto‐pick it:
        if ($comboCount === 1) {
            $one = $request->user()->lembagaRoles()->first();
            $request->session()->put('current_lembaga_id', $one->pivot->lembaga_id);
            $request->session()->put('current_role_id',    $one->pivot->role_id);
            return $next($request);
        }

        // If they have >1 assignment but haven’t picked yet, redirect to choose-role
        if (! $request->is('choose-role*')) {
            return redirect()->route('auth.choose_role');
        }

        return $next($request);
    }
}
