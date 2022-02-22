<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        /**
         * If the user is inactive, log them out and go to login page
         */
        if (!Auth::user()->active) {

            Auth::logout();

            return redirect()
                  ->route('login')
                  ->withMessage('Your account is inactive.');
        }

        return $next($request);
    }
}
