<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user  = Auth::user();

        if ($user && $user->status == 1) {
            return $next($request);
        }

        if ($request->routeIs('profile-edit')) {
            return $next($request);
        }
        return redirect()->route('profile-edit')->with('error', 'Your account is currently inactive. Please reach out to the support team for assistance.');
    }
}
