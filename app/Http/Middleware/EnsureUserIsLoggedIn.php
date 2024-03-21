<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class EnsureUserIsLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if 'user' session key is set
        if (!Session::has('user')) {
            // If the user session is not set, redirect to the login page
            return redirect('/login');
        }

        // If the user session is set, proceed with the request
        return $next($request);
    }
}
