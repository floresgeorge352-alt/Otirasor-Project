<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;

class TwoFactorController extends Controller
{
    public function index(Request $request): View
    {
        return view('profile.two-factor', ['user' => $request->user()]);
    }

    public function enable(Request $request, EnableTwoFactorAuthentication $enable): RedirectResponse
    {
        $enable($request->user());

        return back()->with('success', 'Two-factor authentication has been enabled. Please confirm by entering a code.');
    }

    public function confirm(Request $request, ConfirmTwoFactorAuthentication $confirm): RedirectResponse
    {
        $request->validate(['code' => 'required|string']);

        $confirm($request->user(), $request->input('code'));

        return back()->with('success', 'Two-factor authentication is now fully enabled.');
    }

    public function showRecoveryCodes(Request $request): View
    {
        return view('profile.recovery-codes', ['user' => $request->user()]);
    }

    public function regenerateRecoveryCodes(Request $request, GenerateNewRecoveryCodes $generate): RedirectResponse
    {
        $generate($request->user());

        return back()->with('success', 'Recovery codes regenerated.');
    }

    public function disable(Request $request, DisableTwoFactorAuthentication $disable): RedirectResponse
    {
        $disable($request->user());

        return back()->with('success', 'Two-factor authentication has been disabled.');
    }
}