<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->locale) {
            App::setLocale(auth()->user()->locale);
        } else if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        } else {
            $locale = $request->getPreferredLanguage(['ru', 'en']);
            App::setLocale($locale);
            session()->put('locale', $locale);
        }

        return $next($request);
    }
}
