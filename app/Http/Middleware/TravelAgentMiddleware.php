<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TravelAgentMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('agent')->check()) {
            return redirect()->route('agent.login');
        }

        return $next($request);
    }
}
