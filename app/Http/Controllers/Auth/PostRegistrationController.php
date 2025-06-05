<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LembagaSetupRequest;
use App\Models\Lembaga;
use App\Models\Role;
use App\Models\SubscriptionStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Carbon\Carbon;

class PostRegistrationController extends Controller
{
    /**
     * Show the lembaga setup form after registration.
     */
    public function showLembagaSetup(): View
    {
        // Make sure user is authenticated and doesn't have any roles yet
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // If user already has roles, redirect to role selection or dashboard
        if ($user->hasAnyRole()) {
            return redirect()->route('auth.choose_role');
        }

        return view('auth.setup-lembaga');
    }

    /**
     * Handle lembaga creation after registration.
     */
    public function createLembaga(LembagaSetupRequest $request): RedirectResponse
    {
        $user = Auth::user();

        try {
            // Create the lembaga
            $lembagaData = [
                'name' => $request->validated()['name'],
                'industry' => $request->validated()['industry'] ?? null,
                'phone' => $request->validated()['phone'] ?? null,
                'email' => $request->validated()['email'] ?? null,
                'address' => $request->validated()['address'] ?? null,
            ];

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = 'lembaga_' . uniqid() . '.' . $file->extension();

                // store on 'public' disk explicitly
                $path = $file->storeAs('lembaga-logos', $filename, 'public');

                $lembagaData['logo_path'] = $path; // don't need str_replace anymore
            } 

            $lembaga = Lembaga::create($lembagaData);

            // Get or create 'admin' role
            $adminRole = Role::firstOrCreate(
                ['role_name' => 'admin'],
                [
                    'role_name' => 'admin',
                    'display_name' => 'Administrator',
                    'description' => 'Full access administrator'
                ]
            );

            // Assign user as admin in this lembaga
            $user->lembagaRoles()->attach($adminRole->id, [
                'lembaga_id' => $lembaga->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create trial subscription
            SubscriptionStatus::create([
                'lembaga_id' => $lembaga->id,
                'status' => 'trial',
                'tier' => 'free',
                'start_date' => Carbon::today(),
                'end_date' => Carbon::today()->addDays(14), // 14-day trial
                'is_active' => true,
            ]);

            // Set session for current role and lembaga
            session([
                'current_lembaga_id' => $lembaga->id,
                'current_role_id' => $adminRole->id,
            ]);

            return redirect()
                ->route('dashboard')
                ->with('success', 'Lembaga berhasil dibuat! Anda mendapat trial 30 hari gratis.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal membuat lembaga. Silakan coba lagi.']);
        }
    }
}