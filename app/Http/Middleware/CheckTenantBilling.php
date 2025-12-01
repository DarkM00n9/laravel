<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTenantBilling
{
    public function handle(Request $request, Closure $next)
    {
        $company = app()->bound('tenant') ? app('tenant') : null;

        if (! $company) {
            return $next($request);
        }

        if ($company->contract_end_at && $company->contract_end_at->isPast()) {
            $company->update([
                'billing_status' => 'suspended',
                'is_suspended'   => true,
            ]);
        }

        if ($company->is_suspended || $company->billing_status === 'suspended') {
            return response()->view('errors.tenant_suspended', [
                'company' => $company,
            ], 402);
        }

        return $next($request);
    }
}
