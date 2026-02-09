<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! auth()->check()) {
            abort(403);
        }

        $user = auth()->user();

        // ambil nama role dari relasi
        $userRole = optional($user->role)->name;

        if (! $userRole || ! in_array($userRole, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
