<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription | ArtSHOP</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="auth-body">
    <div class="auth-container">

        <div class="auth-visual">
            <div class="visual-overlay">
                <h2>Rejoignez la communauté.</h2>
                <p>Exposez vos créations au monde entier.</p>
            </div>
        </div>

        <div class="auth-form-box">
            <div class="form-toggle">
                <a href="{{ route('login') }}">Connexion</a>
                <a href="{{ route('register') }}" class="active">Inscription</a>
            </div>

            <form method="POST" action="{{ route('register') }}" class="auth-form active-form">
                @csrf
                <h3>Créer un compte</h3>

                @if($errors->any())
                    <div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:8px;margin-bottom:15px;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="input-group">
                    <label>Nom Complet</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Jean Bekolo" required>
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="contact@exemple.com"
                        required>
                </div>
                <div class="input-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <div class="input-group">
                    <label>Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" required>
                </div>
                <div class="input-group">
                    <label>Je suis un :</label>
                    <div class="role-selector">
                        <input type="radio" name="role" id="client" value="client" checked>
                        <label for="client"><i class="fa-solid fa-cart-shopping"></i> Acheteur</label>
                        <input type="radio" name="role" id="artist" value="artiste">
                        <label for="artist"><i class="fa-solid fa-palette"></i> Artiste</label>
                    </div>
                </div>
                <button type="submit" class="btn-submit">Créer mon compte</button>
            </form>
        </div>

    </div>
</body>

</html>
