<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServerSideErrorsMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response instanceof JsonResponse && $response->getStatusCode() === 500) {
            $response->setData([
                'success' => false,
                'message' => __('errors.serverError'),
            ]);
        }

        return $response;
    }
}
