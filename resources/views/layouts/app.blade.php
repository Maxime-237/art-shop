{{-- Layout principal (navbar ArtSHOP, footer) --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ArtSHOP | Marketplace d\'Excellence')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;600&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')

    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<body>

    <nav class="navbar">
        <div class="logo"><span>ART</span>SHOP</div>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Accueil</a></li>
            <li><a href="{{ route('oeuvres.index') }}">Boutique</a></li>
            <li><a href="#blog">Blog Culturel</a></li>
            <li><a href="#artists">Artistes</a></li>
        </ul>
        <div class="nav-icons">
            <div class="search-trigger"><i class="fa-solid fa-magnifying-glass"></i></div>

            <a href="{{ route('cart.index') }}" class="cart-icon" style="text-decoration: none;color:inherit;">
                <i class="fa-solid fa-bag-shopping"></i>
                <span id="cart-count">{{ session('panier') ? count(session('panier')) : 0 }}</span>
            </a>

            <div class="user-menu">
                @auth

                    <i class="fa-regular fa-circle-user" onclick="toggleUserDashboard()"
                        style="font-size: 1.4rem;cursor: pointer;"></i>

                    <div class="user-dropdown" id="userDropdown">
                        <p class="user-name" style="padding: 10px;
                                        font-weight: 600;"
                        >
                            {{ auth()->user()->name }}
                        </p>

                        <hr>
                        @if(auth()->user()->isArtiste())
                            <a href="{{ route('artiste.dashboard') }}">
                                <i class="fa-solid fa-palette"></i>
                                Mon Studio
                            </a>
                        @endif

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fa-solid fa-shield-halved"></i>
                                 Admin
                            </a>
                        @endif

                        <a href="{{ route('commande.index') }}"><i class="fa-solid fa-box"></i> Mes commandes</a>
                        <a href="#" onclick="openSettings()"><i class="fa-solid fa-gear"></i> Paramètres</a>
                        <a href="#"><i class="fa-solid fa-heart"></i> Favoris</a>

                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf

                            <button type="submit" class="logout-btn"
                                                    style="width:100%;
                                                        text-align:left;
                                                        padding:10px;
                                                        background:none;
                                                        border:none;
                                                        cursor:pointer;
                                                        color:inherit;
                                                        font-size:0.9rem;"
                            >
                                <i class="fa-solid fa-sign-out"></i>
                                Déconnexion
                            </button>
                        </form>
                    </div>

                @else

                    <a href="{{ route('login') }}" style="color:inherit;">
                        <i class="fa-regular fa-circle-user" style="font-size:1.4rem;"></i>
                    </a>

                @endauth

            </div>
        </div>

        {{-- HAMBURGER --}}
        <div class="hamburger" id="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    {{-- MENU MOBILE --}}

    <div class="mobile-menu" id="mobileMenu">

        <a href="{{ route('home') }}">Accueil <span class="arrow">›</span></a>
        <a href="{{ route('oeuvres.index') }}">Boutique <span class="arrow">›</span></a>
        <a href="#blog">Blog Culturel <span class="arrow">›</span></a>
        <a href="#artists">Artistes <span class="arrow">›</span></a>

        @auth
            <a href="{{ route('commande.index') }}">Mes commandes <span class="arrow">›</span></a>
            @if(auth()->user()->isArtiste())
                <a href="{{ route('artiste.dashboard') }}">Mon Studio <span class="arrow">›</span></a>
            @endif
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}">Administration <span class="arrow">›</span></a>
            @endif
            <div class="mobile-menu-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:#e53e3e;font-size:1rem;cursor:pointer;">
                        Déconnexion
                    </button>
                </form>
            </div>
        @else
            <div class="mobile-menu-footer">
                <a href="{{ route('login') }}">Connexion</a>
                <a href="{{ route('register') }}">Inscription</a>
            </div>
        @endauth
    </div>

    {{-- Messages flash --}}

    @if(session('success'))
        <div style="background:#d4edda;color:#155724;padding:12px 5%;border-bottom:1px solid #c3e6cb;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#f8d7da;color:#721c24;padding:12px 5%;border-bottom:1px solid #f5c6cb;">
            <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    @yield('content')

    {{-- Modals Parametres --}}

    @auth

        <div id="settingsModal" class="modal">
            <div class="modal-content">

                <span class="close" onclick="closeSettings()">&times;</span>
                <h2>Paramètres du Compte</h2>

                <form class="settings-form" action="{{ route('profile.update') }}" method="POST">
                    @csrf @method('PATCH')

                    <div class="input-group">
                        <label>Nom Complet</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}">
                    </div>

                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}">
                    </div>

                    <div class="input-group">
                        <label>Devise Préférée</label>
                        <select>
                            <option>FCFA (XAF)</option>
                            <option>Euro (€)</option>
                            <option>Dollar ($)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-primary">Enregistrer les modifications</button>
                </form>

            </div>
        </div>

    @endauth


    <footer>
        <div class="footer-content" style="text-align:center; padding: 40px 0;">
            <div class="footer-logo" style="font-weight: 800"><span style="color: var(--accent)">ART</span>SHOP</div>
            <p>Promouvoir l'excellence artistique du Cameroun à l'échelle mondiale.</p>
        </div>

        <hr>

        <p class="copy" style="text-align:center; padding: 20px 0;">&copy; {{ date('Y') }} Cameroon Art Marketplace. Tous droits
            réservés.</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')

</body>

</html>
