<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

// 🔥 Nos middlewares custom
use App\Http\Middleware\SetTenantFromSubdomain;
use App\Http\Middleware\CheckTenantBilling;

class Kernel extends HttpKernel
{
    /**
     * Application global HTTP middleware stack.
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
    ];

    /**
     * Middleware groups
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            // 🔥 Ajout du multi-tenant
            SetTenantFromSubdomain::class,
        ],

        'api' => [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Route middleware
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // 🔥 Ajout du check contrat/billing
        'tenant.billing' => CheckTenantBilling::class,
    ];
}
