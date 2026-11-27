<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * Display customer account page.
     * 
     * NOTE: Since we combined the Dashboard and Account page,
     * this method now simply redirects to the dashboard.
     */
    public function show()
    {
        return redirect()->route('dashboard');
    }

    /**
     * Update customer profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $emailChanged = $user->email !== $validated['email'];

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;

        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $request->file('avatar')
                ->store('avatars', 'public');
        }

        $user->save();

        if ($emailChanged) {
            $user->sendEmailVerificationNotification();

            return back()
                ->with('success', 'Profile updated. Please verify your new email address using the verification link we sent you.')
                ->with('tab', 'profile');
        }

        return back()
            ->with('success', 'Your profile has been updated successfully.')
            ->with('tab', 'profile');
    }

    /**
     * Upload or replace customer avatar.
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $user = Auth::user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = $request->file('avatar')
            ->store('avatars', 'public');

        $user->save();

        return back()
            ->with('success', 'Profile picture updated successfully.')
            ->with('tab', 'profile');
    }

    /**
     * Remove customer avatar.
     */
    public function removeAvatar()
    {
        $user = Auth::user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);

            $user->avatar = null;
            $user->save();
        }

        return back()
            ->with('success', 'Profile picture removed successfully.')
            ->with('tab', 'profile');
    }

    /**
     * Update customer password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $user = Auth::user();

        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()
            ->with('success', 'Your password has been changed successfully.')
            ->with('tab', 'security');
    }

    /**
     * Update customer preferences.
     */
    public function updatePreferences(Request $request)
    {
        $user = Auth::user();

        $user->email_notifications = $request->boolean(
            'email_notifications'
        );

        $user->save();

        return back()
            ->with('success', 'Your preferences have been saved.')
            ->with('tab', 'preferences');
    }

    /**
     * Check whether customer has active bookings.
     */
    private function hasActiveBookings($userId): bool
    {
        if (!Schema::hasTable('bookings')) {
            return false;
        }

        $activeStatuses = [
            'pending',
            'confirmed',
            'pending cancellation',
            'pending_cancellation',
        ];

        return DB::table('bookings')
            ->where('user_id', $userId)
            ->whereIn(
                DB::raw('LOWER(TRIM(status))'),
                $activeStatuses
            )
            ->exists();
    }

    /**
     * Delete customer account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'delete_password' => ['required', 'string'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->delete_password, $user->password)) {
            return back()
                ->withErrors([
                    'delete_password' => 'The password you entered is incorrect.',
                ])
                ->with('tab', 'security');
        }

        if ($this->hasActiveBookings($user->id)) {
            return back()
                ->withErrors([
                    'delete_password' => 'You cannot delete your account while you have Pending, Confirmed, or Pending Cancellation bookings.',
                ])
                ->with('tab', 'security');
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Your account has been deleted successfully.');
    }
}