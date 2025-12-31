<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only process authenticated users
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();
        
        // Load roles to ensure they're available
        $user->load('roles');
        
        $isAdmin = $user->hasRole('admin');
        $currentPath = $request->path();
        
        // Allow access to welcome page (/) for everyone regardless of role
        if ($currentPath === '' || $currentPath === '/') {
            return $next($request);
        }
        
        // ROLE-BASED REDIRECTION LOGIC:
        // Admin users should ONLY access /adminDashboard
        // Regular users should ONLY access /dashboard
        
        // If admin tries to access regular dashboard, redirect to admin dashboard
        if ($isAdmin && ($currentPath === 'dashboard' || $currentPath === 'dashboard/')) {
            return redirect()->route('adminDashboard')->with('info', 'Admins are redirected to the Admin Dashboard.');
        }
        
        // If regular user tries to access admin dashboard, redirect to regular dashboard
        if (!$isAdmin && ($currentPath === 'adminDashboard' || $currentPath === 'adminDashboard/')) {
            return redirect()->route('dashboard')->with('info', 'This area is restricted to administrators.');
        }
        
        return $next($request);
    }
}
