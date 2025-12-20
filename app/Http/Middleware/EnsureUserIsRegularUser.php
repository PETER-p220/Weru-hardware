<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsRegularUser
{
    /**
     * Handle an incoming request.
     * 
     * Restricts access to regular user routes. Only users without 'admin' role can proceed.
     * Admin users will be redirected to their admin dashboard.
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

        // If user is admin, redirect to admin dashboard
        if ($user->hasRole('admin')) {
            return redirect()->route('adminDashboard')->with('info', 'Administrators should use the Admin Dashboard.');
        }

        return $next($request);
    }
}
