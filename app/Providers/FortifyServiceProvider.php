<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Contracts\TwoFactorChallengeViewResponse;
use Laravel\Fortify\Contracts\ConfirmPasswordViewResponse;
use Laravel\Fortify\Http\Responses\SimpleViewResponse;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse; // <-- IDINAGDAG

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bindings para hindi mag-error ang Fortify
        $this->app->singleton(LoginViewResponse::class, function () {
            return new SimpleViewResponse('auth.login');
        });

        $this->app->singleton(TwoFactorChallengeViewResponse::class, function () {
            return new SimpleViewResponse('auth.two-factor-challenge');
        });

        $this->app->singleton(ConfirmPasswordViewResponse::class, function () {
            return new SimpleViewResponse('auth.confirm-password');
        });

        // === ITO ANG MAG-AYOS NG REDIRECT PAGKATAPOS NG 2FA ===
        $this->app->singleton(TwoFactorLoginResponse::class, function () {
            return new class implements TwoFactorLoginResponse {
                public function toResponse($request) {
                    $user = auth()->user();
                    if ($user->role === 'admin') {
                        return redirect('/admin/dashboard');
                    } elseif ($user->role === 'employee') {
                        return redirect('/employee/dashboard');
                    }
                    return redirect('/dashboard');
                }
            };
        });
    }

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        // Custom Auth
        Fortify::authenticateUsing(function (Request $request) {
            $user = \App\Models\User::where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}