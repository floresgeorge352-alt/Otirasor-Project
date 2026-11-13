<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Siguraduhing naka-login ang user
        if (!auth()->check()) {
            return redirect('/login');
        }

        // 2. Kunin ang role ng user
        $userRole = auth()->user()->role;

        // 3. Kung tugma ang role sa hinihingi ng route, papasukin siya
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // 4. Kapag hindi tugma, i-block siya
        abort(403, 'Unauthorized access. You do not have the right role to view this page.');
    }
}