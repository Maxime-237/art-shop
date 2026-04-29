<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion | CamerArt</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="auth-body">
<div class="auth-container">

    <div class="auth-visual">
        <div class="visual-overlay">
            <h2>L'art camerounais vous attend.</h2>
            <p>Connectez-vous pour soutenir nos talents locaux.</p>
        </div>
    </div>

    <div class="auth-form-box">
        <div class="form-toggle">
            <a href="{{ route('login') }}" class="active" style="text-decoration: none">Connexion</a>
            <a href="{{ route('register') }}" style="text-decoration: none">Inscription</a>
        </div>

        <form method="POST" action="{{ route('login') }}" class="auth-form active-form">
            @csrf
            <h3>Bon retour !</h3>

            @if($errors->any())
                <div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:8px;margin-bottom:15px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="contact@exemple.com" required>
            </div>
            <div class="input-group">
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <div style="margin-bottom:15px;">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" style="font-size:0.9rem;">Se souvenir de moi</label>
            </div>
            <button type="submit" class="btn-submit">Se connecter</button>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-pw">Mot de passe oublié ?</a>
            @endif
        </form>
    </div>

</div>
</body>
</html>
