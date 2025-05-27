<?php

namespace App\Http\Controllers;

use App\Models\CashLedger;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index(Request $request){
        $cashLedger = CashLedger::with(['outlet'])
            ->orderBy('tanggal', 'desc')
            ->get();
      
        if ($request->ajax()) {
            return view('kas-ledger', compact('cashLedger'));
        }
        return view('layouts.admin', [
            'title' => 'Cash Ledger',
            'slot' => view('kas-ledger', [
                'cashLedger' => $cashLedger,
            ]),
        ]);
    }

    public function create(){
        return view('');
    }
    
    public function store(){
        return view('kas-ledger');
    }
    
    // public function edit(Request $request): Response
    // {
    //     return Inertia::render('Profile/Edit', [
    //         'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
    //         'status' => session('status'),
    //     ]);
    // }

    // /**
    //  * Update the user's profile information.
    //  */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit');
    // }

    // /**
    //  * Delete the user's account.
    //  */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
}
