<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Not logged in → redirect to login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Logged in but not admin → block admin pages ONLY
        if (!auth()->user()->isAdmin()) {
            // IMPORTANT:
            // Do NOT abort globally, it breaks logout & UX
            return redirect()
                ->route('dashboard')
                ->with('danger', 'Access denied — Admins only.');
        }

        // Admin → allow
        return $next($request);
    }
}
