<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $tenant = app()->bound('tenant') ? app('tenant') : null;

        return view('auth.login', ['tenant' => $tenant]);
    }

    public function login(Request $request)
    {
        $tenant = app()->bound('tenant') ? app('tenant') : null;

        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $query = User::query()->where('email', $credentials['email']);

        // Si on est sur un sous-domaine tenant, on restreint au tenant
        if ($tenant) {
            $query->where('company_id', $tenant->id);
        }

        $user = $query->first();

        if (! $user || ! password_verify($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Identifiants incorrects.',
            ])->onlyInput('email');
        }

        Auth::login($user, $request->boolean('remember'));

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
