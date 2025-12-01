use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $tenant = app()->bound('tenant') ? app('tenant') : null;

    if (! $tenant) {
        return "ADMIN GLOBAL — Aucun tenant détecté.";
    }

    return "CRM du tenant : " . $tenant->name . " (sous-domaine : " . $tenant->subdomain . ")";
})->middleware('tenant.billing');
