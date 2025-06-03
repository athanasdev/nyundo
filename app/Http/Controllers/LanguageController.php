<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request, $language)
    {
        $availableLanguages = ['en', 'es', 'fr', 'de', 'ar', 'zh'];

        if (in_array($language, $availableLanguages)) {
            Session::put('language', $language);
        }

        return Redirect::back();
    }
}
