<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('auth.login.show')->with('error', 'You must be logged in to access the admin panel.');
        }

        // Check if user is admin
        if (!(bool) auth()->user()->is_admin) {
            abort(403, 'You are not authorized to access the admin panel.');
        }

        return $next($request);
    }
}
