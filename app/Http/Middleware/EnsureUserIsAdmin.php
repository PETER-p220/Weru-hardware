<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     * 
     * Restricts access to admin-only routes. Only users with 'admin' role can proceed.
     * Regular users will be redirected to their dashboard with an error message.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Must be authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        $user = Auth::user();
        $user->load('roles');

        // Check if user has admin role
        if (!$user->hasRole('admin')) {
            // Regular users are redirected to their dashboard
            return redirect()->route('dashboard')->with('error', 'Access denied. This area is restricted to administrators only.');
        }

        return $next($request);
    }
}
