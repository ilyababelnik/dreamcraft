<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === Role::admin) {
            return $next($request);
        }

        return response()->json([
            'success' => false,
            'message' => __('errors.permissionsError'),
        ], 403);
    }
}
