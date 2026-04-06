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
    if (Auth::guard('web')->check() || Auth::guard('institute_users')->check()) {
        if ($request->routeIs('account-deleted')) {
            Auth::logout();
            return $next($request);
        }

        if (Auth::user()->dsstatus == 1) {
            return redirect()->route('account-deleted');
        }
        if (Auth::user()->dsstatus == 0) {
            dd("work");
        }
        return $next($request);
    }
    return redirect()->route('login');
}
}

