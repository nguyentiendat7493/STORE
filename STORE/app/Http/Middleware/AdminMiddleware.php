<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->guest('/login');
        }

        if (! in_array($request->user()->role, ['super_admin', 'admin'], true)) {
            abort(403, 'You do not have permission to access the admin area.');
        }

        return $next($request);
    }
}
