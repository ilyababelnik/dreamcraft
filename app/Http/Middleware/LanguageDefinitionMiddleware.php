<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageDefinitionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('Accept-Language');
        if ($locale) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
