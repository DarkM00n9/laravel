<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;

class SetTenantFromSubdomain
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost(); // ex: gse.monndd.com
        $parts = explode('.', $host);

        $subdomain = $parts[0] ?? null;

        // Cas admin global ou autres
        if (in_array($subdomain, ['admin', 'www']) || $host === 'localhost') {
            return $next($request);
        }

        $company = Company::where('subdomain', $subdomain)->first();

        if (! $company) {
            abort(404, 'Espace client introuvable.');
        }

        app()->instance('tenant', $company);

        return $next($request);
    }
}
