<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

// 🔥 AJOUT ICI
use App\Http\Middleware\SetTenantFromSubdomain;
use App\Http\Middleware\CheckTenantBilling;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     */
    protected $middleware = [
        // Laravel par défaut
        \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
    ];

    /**
     * The application's route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            // 🔥 AJOUT DU MULTI-TENANT
            SetTenantFromSubdomain::class,
        ],

        'api' => [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        
        // 🔥 AJOUT DU CHECK CONTRAT / BILLING
        'tenant.billing' => CheckTenantBilling::class,
    ];
}
