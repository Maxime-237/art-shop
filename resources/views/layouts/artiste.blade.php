{{--  Layout studio artiste --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Artist Studio | ARTSHOP')</title>
    <link rel="stylesheet" href="{{ asset('css/artist.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body>

    <div class="dashboard-wrapper">

        {{-- Sidebar --}}

        <aside class="sidebar">
            <div class="sidebar-header">

                <div class="logo"><span>ART</span>SHOP</div>
                <p class="role-badge">Artist Pro</p>
            </div>

            <nav class="sidebar-menu">
                <a href="{{ route('artiste.dashboard') }}" class="{{ request()->routeIs('artiste.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i> Vue d'ensemble
                </a>
                <a href="{{ route('artiste.dashboard') }}" data-section="portfolio">
                    <i class="fa-solid fa-palette"></i> Mon Portfolio
                </a>
                <a href="{{ route('commande.index') }}">
                    <i class="fa-solid fa-truck-ramp-box"></i> Commandes
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="{{ route('home') }}">
                    <i class="fa-solid fa-house"></i>
                    Retour au site
                </a>

                <form action="{{ route('logout') }}" method="POST">

                    @csrf
                    <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer; font-size: 0.9rem;">
                        <i class="fa-solid fa-sign-out"></i>Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        {{-- Contenu --}}

        <main class="main-content">
            @if (session('success'))

                <div style="background:#d4edda;color:#155724;padding:12px 20px;border-radius:8px;margin-bottom:20px;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>

            @endif

            @if(session('error'))
                <div style="background:#f8d7da;color:#721c24;padding:12px 20px;border-radius:8px;margin-bottom:20px;">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    <script src="{{ asset('js/artist.js') }}"></script>
    @stack('scripts')

</body>
</html>
