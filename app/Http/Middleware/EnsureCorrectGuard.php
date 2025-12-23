<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureCorrectGuard
{
    protected $guard;

    public function __construct($guard = null)
    {
        $this->guard = $guard;
    }

    public function handle(Request $request, Closure $next, $guard = null)
    {
        $guard = $guard ?? $this->guard;
         
        // Check if the user is authenticated with the correct guard
        if (!auth()->guard($guard)->check()) {
            return redirect("/$guard/login")->with('error', 'Access Denied.');
        }

        return $next($request);
    }
}
