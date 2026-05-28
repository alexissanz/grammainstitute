<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private array $allowed = ['pt_BR', 'en', 'es', 'he', 'el', 'la'];

    public function handle(Request $request, Closure $next): Response
    {
        $settings = SiteSetting::current();
        $defaultLocale = $settings->idioma_padrao ?: config('app.locale', 'en');
        $activeLocales = array_values(array_filter($settings->idiomas_activos ?? []));
        $allowed = $activeLocales ?: $this->allowed;
        $locale = session('locale', $defaultLocale);

        if (!in_array($locale, $allowed, true)) {
            $locale = $defaultLocale;
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
