<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleChoiceController extends Controller
{
    /**
     * Show a list of (lembaga, role) combos that the user can pick.
     */
    public function show()
    {
        $user = Auth::user();
        // eager‐load lembagaRoles → so we get Role models + pivot (lembaga_id)
        $combos = $user->lembagaRoles()->with('lembagas')->get();

        // $combos is a Collection of Role models; each has pivot->lembaga_id
        // If you also want lembaga name readily available, you can load it:
        // $comboRows = $user->lembagaRoles()->get()->map(function($role) {
        //   return [
        //     'role_id' => $role->id,
        //     'role_name' => $role->role_name,
        //     'lembaga_id' => $role->pivot->lembaga_id,
        //     'lembaga_name' => \App\Models\Lembaga::find($role->pivot->lembaga_id)->name,
        //   ];
        // });
        // In Blade we can look up Lembaga::find($role->pivot->lembaga_id)->name, too.

        return view('auth.choose_role', compact('combos'));
    }

    /**
     * Handle the POST when the user picks which (lembaga, role) they want.
     */
    public function pick(Request $request)
    {
        $request->validate([
            'lembaga_id' => 'required|exists:lembaga,id',
            'role_id'    => 'required|exists:roles,id',
        ]);

        $user = Auth::user();

        // Verify that this user actually has that (lembaga, role) combination
        $exists = $user->lembagaRoles()
                       ->wherePivot('lembaga_id', $request->lembaga_id)
                       ->where('roles.id', $request->role_id)
                       ->exists();

        if (! $exists) {
            return back()->withErrors(['You do not have that role in the selected lembaga.']);
        }

        // Store in session
        $request->session()->put('current_lembaga_id', $request->lembaga_id);
        $request->session()->put('current_role_id', $request->role_id);

        return redirect()->route('dashboard');
    }
}

?>