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
        /*
        |--------------------------------------------------------------------------
        | ADMIN LOGIN
        |--------------------------------------------------------------------------
        */

        if ($request->is('admin/login')) {
            return view('auth.admin-login');
        }


        /*
        |--------------------------------------------------------------------------
        | EMPLOYEE LOGIN
        |--------------------------------------------------------------------------
        */

        if ($request->is('employee/login')) {
            return view('auth.employee-login');
        }


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER LOGIN
        |--------------------------------------------------------------------------
        */

        return view('auth.login');
    }


    /**
     * Handle customer login.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();


        /*
        |--------------------------------------------------------------------------
        | BLOCK ADMIN AND EMPLOYEE ACCOUNTS
        |--------------------------------------------------------------------------
        */

        if (in_array(auth()->user()->role, ['admin', 'employee'], true)) {

            Auth::guard('web')->logout();

            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' =>
                        'This account is not authorized for the Customer Portal.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER ACCOUNT
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }


    /**
     * Handle admin login.
     */
    public function storeAdmin(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();


        /*
        |--------------------------------------------------------------------------
        | CHECK ADMIN ROLE
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role !== 'admin') {

            Auth::guard('web')->logout();

            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' =>
                        'This account is not authorized for the Admin Portal.',
                ]);
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


        /*
        |--------------------------------------------------------------------------
        | CHECK EMPLOYEE ROLE
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role !== 'employee') {

            Auth::guard('web')->logout();

            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' =>
                        'This account is not authorized for the Employee Portal.',
                ]);
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