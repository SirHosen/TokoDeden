<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // Handle profile photo upload
        if ($request->hasFile('avatar')) {
            // Delete previous photo if exists
            if ($user->avatar && file_exists(public_path('storage/' . $user->avatar))) {
                unlink(public_path('storage/' . $user->avatar));
            }

            // Store new photo
            $photoPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $photoPath;
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

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

    public function updateAddress(Request $request): RedirectResponse
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'address_name' => 'nullable|string|max:50',
            'is_default_address' => 'nullable|boolean',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $user = $request->user();
        $user->update([
            'address' => $request->address,
            'phone' => $request->phone,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'address_name' => $request->address_name ?? ($request->is_default_address ? 'Alamat Utama' : null),
            'is_default_address' => $request->boolean('is_default_address'),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return Redirect::route('profile.edit')->with('status', 'address-updated');
    }
}
