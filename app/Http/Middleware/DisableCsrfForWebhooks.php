<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisableCsrfForWebhooks
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Define webhook routes that should skip CSRF
        $webhookRoutes = [
            'selcom/webhook',
            'api/webhook/*', // Add other webhooks if needed
        ];

        foreach ($webhookRoutes as $route) {
            if ($request->is($route)) {
                // Skip CSRF verification for this route
                return $next($request);
            }
        }

        return $next($request);
    }
}