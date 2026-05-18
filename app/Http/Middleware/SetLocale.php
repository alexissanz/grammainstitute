<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private array $allowed = ['pt_BR', 'en', 'es', 'he', 'el', 'la'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('app.locale', 'pt_BR'));

        if (!in_array($locale, $this->allowed)) {
            $locale = 'pt_BR';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
