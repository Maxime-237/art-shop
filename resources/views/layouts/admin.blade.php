{{-- Layout admin (sidebar AdminCore) --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Central | ARTSHOP')</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>

<body>

    <div class="admin-container">

        {{-- SIDEBAR --}}

        <nav class="admin-sidebar">
            <div class="sidebar-brand">
                <i class="fa-solid fa-shield-halved"></i> <span>ADMIN<span>CORE</span></span>
            </div>
            <ul class="admin-menu">
                <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}"
                        style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:12px;width:100%;">
                        <i class="fa-solid fa-gauge"></i> Tableau de bord
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}" style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:12px;width:100%;">
                         <i class="fa-solid fa-users-gear"></i> Utilisateurs
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.oeuvres.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.oeuvres.index') }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 12px; width: 100%;">
                        <i class="fa-solid fa-box-open"></i> Catalogue Produits
                    </a>

                </li>

                <li>
                    <a href="#" style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:12px;width:100%;">
                        <i class="fa-solid fa-money-bill-trend-up"></i> Finances
                    </a>
                </li>
            </ul>

            <div class="sidebar-bottom">
                <a href="{{ route('home') }}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Retour au site</a>

                <form action="{{ route('logout') }}" method="POST" style="margin-top: 10px;">
                    @csrf

                    <button type="submit" style="background: none; cursor: pointer; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-power-off"></i> Déconnexion
                    </button>
                </form>
            </div>
        </nav>

        {{-- CONTENU PRINCIPAL --}}

        <main class="admin-main">

            <header class="admin-header">
                <div class="search-box">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" placeholder="Rechercher une transaction, un ID...">
                </div>
                <div class="admin-profile">
                    <span class="status-indicator"></span>
                    <p>{{ auth()->user()->name }}</p>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=e58e26&color=fff" alt="Admin">
                </div>
            </header>

            {{-- Flash messages --}}

            @if (session('success'))

                <div style="margin:20px 30px 0;background:#d4edda;color:#155724;padding:12px 20px;border-radius:8px;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>

            @endif

            @if (session('error'))

                <div style="margin:20px 30px 0;background:#f8d7da;color:#721c24;padding:12px 20px;border-radius:8px;">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>

            @endif

            {{-- Contenu de a page --}}

            @yield('content')


        </main>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
    @stack('scripts')

</body>

</html>
