<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the appropriate login view.
     */
    public function create(Request $request): View
    {
        if ($request->is('admin/login')) {
            return view('auth.admin-login');
        }

        if ($request->is('employee/login')) {
            return view('auth.employee-login');
        }

        return view('auth.login');
    }

    /**
     * Handle customer login.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // 2FA CHECK PARA SA CUSTOMER
        if (auth()->user()->two_factor_secret) {
            $userId = auth()->id();
            Auth::guard('web')->logout();
            $request->session()->put('login.id', $userId);
            $request->session()->put('url.intended', '/my-bookings'); // <-- PALITAN ITO
            return redirect('/two-factor-challenge');
        }

        if (in_array(auth()->user()->role, ['admin', 'employee'], true)) {
            Auth::guard('web')->logout();
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'This account is not authorized for the Customer Portal.',
                ]);
        }

        $request->session()->regenerate();
        return redirect()->intended('/my-bookings'); // <-- PALITAN ITO
    }

    /**
     * Handle admin login.
     */
    public function storeAdmin(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        if (auth()->user()->role !== 'admin') {
            Auth::guard('web')->logout();
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'This account is not authorized for the Admin Portal.',
                ]);
        }

        // 2FA CHECK PARA SA ADMIN
        if (auth()->user()->two_factor_secret) {
            $userId = auth()->id();
            Auth::guard('web')->logout();
            $request->session()->put('login.id', $userId);
            $request->session()->put('url.intended', '/admin/dashboard');
            return redirect('/two-factor-challenge');
        }

        $request->session()->regenerate();
        return redirect('/admin/dashboard');
    }

    /**
     * Handle employee login.
     */
    public function storeEmployee(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        if (auth()->user()->role !== 'employee') {
            Auth::guard('web')->logout();
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'This account is not authorized for the Employee Portal.',
                ]);
        }

        // 2FA CHECK PARA SA EMPLOYEE
        if (auth()->user()->two_factor_secret) {
            $userId = auth()->id();
            Auth::guard('web')->logout();
            $request->session()->put('login.id', $userId);
            $request->session()->put('url.intended', '/employee/dashboard');
            return redirect('/two-factor-challenge');
        }

        $request->session()->regenerate();
        return redirect('/employee/dashboard');
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
}