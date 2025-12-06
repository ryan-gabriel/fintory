<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // ✅ Update email
        $user->email = $request->email;

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // ✅ UPLOAD FOTO KE SUPABASE
        if ($request->hasFile('profile_picture')) {

            $file = $request->file('profile_picture');
            $filename = 'avatar_' . $user->id . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $fileContent = file_get_contents($file->getRealPath());

            $uploadUrl =
                env('SUPABASE_PROJECT_URL') .
                '/storage/v1/object/' .
                env('SUPABASE_AVATARS_BUCKET') .
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
                    'profile_picture' => 'Upload to Supabase failed!'
                ]);
            }

            // ✅ HAPUS FOTO LAMA JIKA ADA
            if ($user->profile_picture) {
                $oldPath = str_replace(
                    env('SUPABASE_PROJECT_URL') . '/storage/v1/object/public/' . env('SUPABASE_AVATARS_BUCKET') . '/',
                    '',
                    $user->profile_picture
                );

                Http::withHeaders([
                    'apikey' => env('SUPABASE_SERVICE_ROLE_KEY'),
                    'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_ROLE_KEY'),
                ])->delete(
                    env('SUPABASE_PROJECT_URL') . '/storage/v1/object/' . env('SUPABASE_AVATARS_BUCKET') . '/' . $oldPath
                );
            }

            // ✅ SIMPAN URL BARU
            $user->profile_picture =
                env('SUPABASE_PROJECT_URL') .
                '/storage/v1/object/public/' .
                env('SUPABASE_AVATARS_BUCKET') .
                '/' .
                $filename;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
