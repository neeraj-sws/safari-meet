<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Admin redirect
        if (($request->is('admin') || $request->is('admin/*')) && Auth::guard('admin')->check()) {
            return redirect('/admin/dashboard');
        }

        // Agent redirect
        if (($request->is('agent') || $request->is('agent/*')) && Auth::guard('agent')->check()) {
            return redirect('/agent/dashboard');
        }

        // Web redirect
        if (Auth::guard('web')->check() && !$this->isAdmin($request) && !$this->isAgent($request)) {
            return redirect('/');
        }

        return $next($request);
    }

    /**
     * Check if the request is for admin routes.
     */
    private function isAdmin(Request $request): bool
    {
        return $request->is('admin') || $request->is('admin/*');
    }

    /**
     * Check if the request is for agent routes.
     */
    private function isAgent(Request $request): bool
    {
        return $request->is('agent') || $request->is('agent/*');
    }
}
