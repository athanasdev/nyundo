<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register helper
        require_once app_path('Helpers/LanguageHelper.php');

        // Share language data with all views
        view()->composer('*', function ($view) {
            $view->with([
                'availableLanguages' => \App\Helpers\LanguageHelper::getAvailableLanguages(),
                'currentLanguage' => \App\Helpers\LanguageHelper::getCurrentLanguage(),
                'isRTL' => \App\Helpers\LanguageHelper::isRTL(),
            ]);
        });
    }
}
