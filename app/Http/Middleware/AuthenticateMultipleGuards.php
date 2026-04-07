<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticateMultipleGuards
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    $guard = null;

    if (Auth::guard('web')->check()) {
        Auth::shouldUse('web');
        $guard = 'web';
    } elseif (Auth::guard('institute_users')->check()) {
        Auth::shouldUse('institute_users');
        $guard = 'institute_users';

    }

    if ($guard) {
        $user = Auth::guard($guard)->user();

        if ($request->routeIs('account-deleted')) {
            Auth::guard($guard)->logout();
            return $next($request);
        }

        if ($user && $user->dsstatus == 1) {
            return redirect()->route('account-deleted');
        }

        if ($user && $user->dsstatus == 0) {
            return $next($request);
        }

        return $next($request);
    }

    return redirect()->route('login');
   }
}