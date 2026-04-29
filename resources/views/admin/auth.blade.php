{{-- Login admin style terminal --}}

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Sécurisé | Admin Terminal</title>
    <link rel="stylesheet" href="{{ asset('css/adminauth.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Inter:wght@400;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <div class="login-overlay"></div>

    <div class="admin-auth-card">
        <div class="auth-header">
            <i class="fa-solid fa-key-skeleton"></i>
            <h1>ADMIN<span>CORE</span></h1>
            <p>Terminal de contrôle V1.0</p>
        </div>

        {{-- Erreurs --}}

        @if ($errors->any())

            <div style="background: #fee2e2; color:#dc2626;padding:12px 16px;border-radius:8px;margin-bottom:15px;font-size:0.9rem;">
                <i>fa-solid fa-triangle-exclamation</i>
                {{ $errors->first() }}
            </div>

        @endif

        @if (session('error'))

            <div style="background:#fee2e2;color:#dc2626;padding:12px 16px;border-radius:8px;margin-bottom:15px;font-size:0.9rem;">
                <i class="fa-solid fa-triangle-exclamation"></i>
                {{ session('error') }}
            </div>

        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-field">
                <label><i class="fa-solid fa-id-badge"></i> Email Admin</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@art-shop.cm" required autofocus>
            </div>

            <div class="input-field">
                <label><i class="fa-solid fa-lock"></i> Code d'accès</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <div class="input-field" style="flex-direction: row; align-items: center; gap: 10px;">

                <input type="checkbox" name="remember" id="remember" style="width: auto;">
                <label><i class="fa-solid fa-shield-halved"></i> Maintenir la session active</label>

            </div>

            <button type="submit" class="btn-login">
                <span>Authentification</span>
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>

        <div class="auth-footer">
            <p>Accès restreint au personnel autorisé uniquement.</p>
            <p class="ip-address">
                <a href="{{ route('login') }}" style="color: #94a3b8; font-size: 0.8rem;">
                    ← Retour à la connexion standard
                </a>
            </p>
        </div>
    </div>

    <script src="{{ asset('js/adminauth.js') }}"></script>
</body>

</html>
