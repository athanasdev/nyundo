<?php

use App\Http\Middleware\NoCacheHeaders;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\SetLanguage;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'stripe/*',
            'nowpayments/validate-address',
            'ipn-callback'
        ]);

        $middleware->alias([
            'no-cache' => \App\Http\Middleware\NoCacheHeaders::class,
             'history' =>\App\Http\Middleware\PreventBackHistory::class,
        ]);

        $middleware->appendToGroup('web', SetLanguage::class);
        $middleware->appendToGroup('web', NoCacheHeaders::class);
        $middleware->appendToGroup('web', PreventBackHistory::class);

    })

    ->withExceptions(function (Exceptions $exceptions) {})
    ->create();
