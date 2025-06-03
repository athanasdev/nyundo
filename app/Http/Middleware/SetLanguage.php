<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLanguage
{
    public function handle(Request $request, Closure $next)
    {
        // Get language from session, URL parameter, or default
        $language = $request->get('lang') ?? Session::get('language', config('app.locale'));

        // Validate language exists
        $availableLanguages = ['en', 'es', 'fr', 'de', 'ar', 'zh']; // Add your supported languages

        if (in_array($language, $availableLanguages)) {
            App::setLocale($language);
            Session::put('language', $language);
        }

        return $next($request);
    }
}
