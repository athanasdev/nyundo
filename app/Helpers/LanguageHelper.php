<?php

namespace App\Helpers;

class LanguageHelper
{
    public static function getAvailableLanguages()
    {
        return [
            'en' => ['name' => 'English', 'flag' => '🇺🇸'],
            'es' => ['name' => 'Español', 'flag' => '🇪🇸'],
            'fr' => ['name' => 'Français', 'flag' => '🇫🇷'],
            'de' => ['name' => 'Deutsch', 'flag' => '🇩🇪'],
            'ar' => ['name' => 'العربية', 'flag' => '🇸🇦'],
            'zh' => ['name' => '中文', 'flag' => '🇨🇳'],
        ];
    }

    public static function getCurrentLanguage()
    {
        return app()->getLocale();
    }

    public static function isRTL($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return in_array($locale, ['ar', 'he', 'fa']);
    }
}
