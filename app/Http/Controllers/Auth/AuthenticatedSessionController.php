<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Lembaga;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Call our custom authenticated logic
        return $this->authenticated($request, Auth::user());
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function authenticated(Request $request, $user)
    {
        // 1) Count how many (lembaga_id, role_id) rows exist for this user
        $combos = $user->lembagaRoles()->get(); 
        $count = $combos->count();

        if ($count === 0) {
            // Set default session values for users without roles
            $request->session()->put('current_lembaga_id', null);
            $request->session()->put('current_role_id', null);
            $request->session()->put('current_subscription_status', null);
            $request->session()->put('current_subscription_tier', null);
            $request->session()->put('current_subscription_is_active', false);
            
            // no assignment—log them out or show "no roles assigned" page
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['You have no role assignment in any lembaga.']);
        }
        else {
            // Send them to "choose your role" page regardless of count
            return redirect()->route('auth.choose_role');
        }
    }
}
