<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * Add/fix security headers on every response.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Remove deprecated Feature-Policy (conflicts with Permissions-Policy)
        $response->headers->remove('Feature-Policy');

        // Set modern Permissions-Policy
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // Prevent MIME-type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        return $response;
    }
}
