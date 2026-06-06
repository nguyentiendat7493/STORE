<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->guest('/login');
        }

        if (! in_array($request->user()->role, ['super_admin', 'admin', 'staff'], true)) {
            abort(403, 'Only staff can access this area.');
        }

        return $next($request);
    }
}
