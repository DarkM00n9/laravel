<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - CRM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="margin:0; font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif; background:#020617; color:#e5e7eb; display:flex; align-items:center; justify-content:center; min-height:100vh;">
    <div style="background:#020617; border:1px solid #1f2937; border-radius:16px; padding:2rem; width:100%; max-width:380px; box-shadow:0 20px 40px rgba(0,0,0,0.6);">
        <h1 style="font-size:1.4rem; margin-bottom:0.25rem; text-align:center;">
            @if(isset($tenant) && $tenant)
                {{ $tenant->name }} – Espace CRM
            @else
                MONNDD – Admin CRM
            @endif
        </h1>
        <p style="font-size:0.85rem; color:#9ca3af; margin-bottom:1.5rem; text-align:center;">
            Connecte-toi pour accéder à ton espace.
        </p>

        @if ($errors->any())
            <div style="background:#7f1d1d; color:#fecaca; padding:0.75rem; border-radius:8px; font-size:0.8rem; margin-bottom:1rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" style="display:flex; flex-direction:column; gap:0.75rem;">
            @csrf

            <label style="font-size:0.85rem; color:#d1d5db;">
                Email
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    style="margin-top:0.25rem; width:100%; padding:0.6rem 0.75rem; border-radius:8px; border:1px solid #374151; background:#020617; color:#e5e7eb;"
                >
            </label>

            <label style="font-size:0.85rem; color:#d1d5db;">
                Mot de passe
                <input
                    type="password"
                    name="password"
                    required
                    style="margin-top:0.25rem; width:100%; padding:0.6rem 0.75rem; border-radius:8px; border:1px solid #374151; background:#020617; color:#e5e7eb;"
                >
            </label>

            <label style="display:flex; align-items:center; gap:0.4rem; font-size:0.8rem; color:#9ca3af; margin-top:0.5rem;">
                <input type="checkbox" name="remember" style="accent-color:#4f46e5;">
                Rester connecté
            </label>

            <button
                type="submit"
                style="margin-top:0.75rem; padding:0.65rem 0.75rem; border-radius:999px; border:none; background:linear-gradient(135deg,#4f46e5,#06b6d4); color:white; font-weight:600; cursor:pointer;"
            >
                Se connecter
            </button>
        </form>

        <p style="margin-top:1.25rem; font-size:0.75rem; color:#6b7280; text-align:center;">
            @if(isset($tenant) && $tenant)
                Connecté à : {{ $tenant->subdomain }}.monndd.com
            @else
                Espace administrateur global.
            @endif
        </p>
    </div>
</body>
</html>
