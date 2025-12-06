<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LembagaSetupRequest;
use App\Models\Lembaga;
use App\Models\Role;
use App\Models\SubscriptionStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
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
            // ✅ DATA LEMBAGA
            $lembagaData = [
                'name' => $request->validated()['name'],
                'industry' => $request->validated()['industry'] ?? null,
                'phone' => $request->validated()['phone'] ?? null,
                'email' => $request->validated()['email'] ?? null,
                'address' => $request->validated()['address'] ?? null,
            ];

            // ✅ UPLOAD LOGO KE SUPABASE
            if ($request->hasFile('logo')) {

                $file = $request->file('logo');
                $filename = 'lembaga_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                $fileContent = file_get_contents($file->getRealPath());

                $uploadUrl =
                    env('SUPABASE_PROJECT_URL') .
                    '/storage/v1/object/' .
                    env('SUPABASE_LEMBAGA_BUCKET') .
                    '/' .
                    $filename;

                $response = Http::withHeaders([
                    'apikey' => env('SUPABASE_SERVICE_ROLE_KEY'),
                    'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_ROLE_KEY'),
                    'Content-Type' => $file->getMimeType(),
                ])
                ->withBody($fileContent, $file->getMimeType())
                ->put($uploadUrl);

                if ($response->failed()) {
                    return back()->withErrors([
                        'logo' => 'Upload logo ke Supabase gagal!'
                    ]);
                }

                // ✅ SIMPAN URL PUBLIC LOGO
                $lembagaData['logo_path'] =
                    env('SUPABASE_PROJECT_URL') .
                    '/storage/v1/object/public/' .
                    env('SUPABASE_LEMBAGA_BUCKET') .
                    '/' .
                    $filename;
            }

            // ✅ SIMPAN LEMBAGA
            $lembaga = Lembaga::create($lembagaData);

            // ✅ ROLE ADMIN
            $adminRole = Role::firstOrCreate(
                ['role_name' => 'super'],
                [
                    'role_name' => 'super',
                    'display_name' => 'Administrator',
                    'description' => 'Full access administrator'
                ]
            );

            // ✅ ATTACH USER KE LEMBAGA
            $user->lembagaRoles()->attach($adminRole->id, [
                'lembaga_id' => $lembaga->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ✅ TRIAL SUBSCRIPTION
            SubscriptionStatus::create([
                'lembaga_id' => $lembaga->id,
                'status' => 'trial',
                'tier' => 'free',
                'start_date' => Carbon::today(),
                'end_date' => Carbon::today()->addDays(14),
                'is_active' => true,
            ]);

            // ✅ SESSION
            session([
                'current_lembaga_id' => $lembaga->id,
                'current_role_id' => $adminRole->id,
            ]);

            return redirect()
                ->route('dashboard')
                ->with('success', 'Lembaga berhasil dibuat! Anda mendapat trial 14 hari gratis.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal membuat lembaga. Silakan coba lagi.']);
        }
    }
}