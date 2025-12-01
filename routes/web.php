<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Page de login (accessible à tout le monde)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Soumission du formulaire de login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard principal (protégé par auth + billing)
Route::get('/', function () {
    $tenant = app()->bound('tenant') ? app('tenant') : null;

    if (! $tenant) {
        // Espace admin global (toi)
        return view('admin-global');
    }

    return view('tenant.dashboard', ['tenant' => $tenant]);
})->middleware(['auth', 'tenant.billing'])->name('dashboard');
