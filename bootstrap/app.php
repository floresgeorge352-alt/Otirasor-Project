
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Failed;
use App\Listeners\LogFailedLogin;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // === MGA CUSTOM MIDDLEWARE ALIAS ===
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'role'  => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // === SECURITY HEADERS ===
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);

        // === TRUSTED PROXIES PARA SA CLOUDFLARE TUNNEL ===
        $middleware->trustProxies(
            at: [
                // Local Cloudflare Tunnel proxy
                '127.0.0.1/32',
                '::1/128',

                // Cloudflare IPv4
                '173.245.48.0/20',
                '103.21.244.0/22',
                '103.22.200.0/22',
                '103.31.4.0/22',
                '141.101.64.0/18',
                '108.162.192.0/18',
                '190.93.240.0/20',
                '188.114.96.0/20',
                '197.234.240.0/22',
                '198.41.128.0/17',
                '162.158.0.0/15',
                '104.16.0.0/13',
                '104.24.0.0/14',
                '172.64.0.0/13',
                '131.0.72.0/22',

                // Cloudflare IPv6
                '2400:cb00::/32',
                '2606:4700::/32',
                '2803:f800::/32',
                '2405:b500::/32',
                '2405:8100::/32',
                '2a06:98c0::/29',
                '2c0f:f248::/32',
            ],
            headers: Request::HEADER_X_FORWARDED_FOR
                | Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PORT
                | Request::HEADER_X_FORWARDED_PROTO
                | Request::HEADER_X_FORWARDED_PREFIX,
        );
    })
    ->withEvents(discover: [
        __DIR__.'/../app/Listeners',
    ])
    ->withExceptions(function (Exceptions $exceptions): void {

        // Custom failed login event listener
        $events = app('events');

        $events->listen(
            Failed::class,
            LogFailedLogin::class
        );
    })
    ->create();
