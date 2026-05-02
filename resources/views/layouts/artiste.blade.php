{{-- Layout studio artiste --}}

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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp">
    @stack('styles')
</head>

<body>

    {{-- HAMBURGER BUTTON --}}
    <button class="hamburger-btn" id="hamburgerBtn" onclick="toggleSidebar()">
        <span></span>
        <span></span>
        <span></span>
    </button>

    {{-- OVERLAY --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="admin-container">

        {{-- SIDEBAR --}}

        <nav class="admin-sidebar" id="adminSidebar">
            <div class="top">
                <div class="sidebar-brand">
                    <i class="fa-solid fa-palette"></i> <span>MON<span> STUDIO</span></span>
                </div>


            </div>

            <ul class="admin-menu">
                <li class="{{ request()->routeIs('artiste.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('artiste.dashboard') }}"
                        style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:12px;width:100%;">
                        <i class="fa-solid fa-chart-line"></i> Vue d'ensemble
                    </a>
                </li>

                <li>
                    <a href="#"
                        style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:12px;width:100%;">
                        <i class="fa-solid fa-images"></i> Mon Portfolio
                    </a>
                </li>

                <li>
                    <a href="{{ route('commande.index') }}"
                        style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:12px;width:100%;">
                        <i class="fa-solid fa-truck-ramp-box"></i> Commandes
                    </a>
                </li>

                <li>
                    <a href="#"
                        style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:12px;width:100%;">
                        <i class="fa-solid fa-wallet"></i> Revenus
                    </a>
                </li>
            </ul>

            <div class="sidebar-bottom" style="margin-bottom: 12px">
                <a href="{{ route('home') }}"
                    style="text-decoration:none;color:inherit;font-size:1.1rem;display:flex;align-items:center;gap:12px;width:100%;">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Retour au site
                </a>

                <form action="{{ route('logout') }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    <button type="submit"
                        style="background: none; cursor: pointer; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; color: #e58e26; width: 100%; border: none">
                        <i class="fa-solid fa-power-off"></i> Déconnexion
                    </button>
                </form>
            </div>
        </nav>

        {{-- CONTENU PRINCIPAL --}}

        <main class="admin-main">
            @if (session('success'))

                <div style="margin:20px 30px 0;background:#d4edda;color:#155724;padding:12px 20px;border-radius:8px;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>

            @endif

            @if(session('error'))
                <div style="margin:20px 30px 0;background:#f8d7da;color:#721c24;padding:12px 20px;border-radius:8px;">
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
