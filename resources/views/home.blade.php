{{-- PAGE D'ACCUEIL --}}

@extends('layouts.app')

@section('title', 'ArtSHOP | Marketplace d\'Excellence')

@section('content')

    {{-- HERO --}}
    <header class="hero" style="background: url('{{ asset('images/back_img.png') }}')" id="home">
        <div class="hero-content">
            <span class="badge">Patrimoine du Cameroun</span>
            <h1>L'Art de nos Terres, <br>Livré chez Vous.</h1>
            <p>La première plateforme dédiée à la promotion et à la vente des chefs-d'œuvre de l'art camerounais.</p>
            <div class="hero-btns">
                <a href="{{ route('oeuvres.index') }}" class="btn-primary">Acheter Maintenant</a>
                <a href="#blog" class="btn-secondary">Découvrir l'Histoire</a>
            </div>
        </div>
    </header>

    {{-- BOUTIQUE --}}
    <section class="shop-section" id="shop">
        <div class="section-header">
            <h2 class="section-title">Marché de l'Art</h2>
            <div class="filters">
                <a href="{{ route('oeuvres.index') }}" class="filter-btn active" style="text-decoration: none; font-weight: bold;">Tous</a>
                @foreach($categories as $category)
                    <a href="{{ route('oeuvres.index', ['categorie' => $category->slug]) }}" class="filter-btn" style="text-decoration: none; font-weight: bold; color: var(--primary); box-shadow: 0 15px 30px  rgba(0, 0, 0 ,0.2);" style=".filter-btn:hover{box-shadow: none}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="product-grid">
            @forelse($oeuvres as $artwork)
                <div class="product-card">
                    <div class="product-img-container">

                        <img src="{{ $artwork->image_url }}" alt="{{ $artwork->titre }}" class="product-img">
                        <div class="card-actions">

                        <a href="{{ route('oeuvres.show', $artwork->slug) }}" class="btn-card btn-detail-view"
                                onclick="openProduct({{ $artwork->id }}})" style="text-decoration: none">
                                <i class="fa-solid fa-eye"></i> Détails
                            </a>
                            @auth
                                <form action="{{ route('cart.add', $artwork) }}" method="POST">
                                    @csrf

                                    <button class="btn-card btn-quick-add" title="Ajouter au panier" type="submit">
                                        <i class="fa-solid fa-bag-shopping"></i> + Panier
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                    <div class="product-info">

                        <small>{{ $artwork->categorie->name }}</small>
                        <h3>{{ $artwork->titre }}</h3>
                        <p>Par {{ $artwork->artiste->name }}</p>
                        <div class="price">{{ number_format($artwork->price, 0, ',', ' ') }} FCFA</div>
                        {{-- <div style="display:flex;gap:10px;margin-top:12px;">
                            <a href="{{ route('oeuvres.show', $artwork->slug) }}" class="btn-primary"
                                style="flex:1;text-align:center;padding:8px;">
                                Voir l'œuvre
                            </a>
                            @auth
                                <form action="{{ route('cart.add', $artwork) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-add" style="padding:8px 14px;" title="Ajouter au panier">
                                        <i class="fa-solid fa-bag-shopping"></i>
                                    </button>
                                </form>
                            @endauth
                        </div> --}}
                    </div>
                </div>
            @empty
                <p style="padding:40px;text-align:center;color:#666;">Aucune œuvre disponible pour le moment.</p>
            @endforelse
        </div>

        <div style="text-align:center;margin-top:40px;">
            <a href="{{ route('oeuvres.index') }}" class="btn-primary">Voir tout le catalogue</a>
        </div>
    </section>

    {{-- ARTISTES --}}

    <section class="artists-section" id="artists">
        <h2 class="section-title">Nos Maîtres Artisans</h2>
        <div class="announcements-ticker">
            <div class="ticker-content">

                @foreach ($users as $artiste)

                    <span><i class="fa-solid fa-bullhorn"></i> <strong>{{ $artiste->name }} : </strong>{{ Illuminate\Support\Str::limit($artiste->bio, 50) }}</span>


                @endforeach

            </div>
        </div>
        <div class="artists-grid" id="artists-list">

            @if ($users)


                @forelse ($users as $artiste)

                    <div class="artist-card">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($artiste->name) }}&background=e58e26&color=fff" alt="{{ $artiste->name }}}">
                        <h3>{{ $artiste->name }}</h3>
                        <p>{{ $artiste->oeuvres->count() }} Oeuvres publiées</p>
                        <small>{{ Illuminate\Support\Str::limit($artiste->bio, 60)}}</small>
                        <div class="artist-news">"{{ $artiste->oeuvres->where('statut', 'disponible')->count() }} Ouvres disponibles"</div>
                    </div>

                @empty

                @endforelse


            @endif

        </div>
    </section>

    {{-- BLOG CULTUREL --}}
    <section class="blog-section" id="blog">
        <h2 class="section-title">Espace Culturel</h2>
        <div class="blog-grid">
            <article class="blog-card">
                <div class="blog-img"
                    style="background-image: url('https://images.unsplash.com/photo-1523891707568-756bb0aca0f0?q=80&w=800');">
                </div>
                <div class="blog-content">
                    <span class="tag">Histoire</span>
                    <h3>Les Bronzes de Foumban : Un secret millénaire</h3>
                    <p>Découvrez comment les artisans du Noun perpétuent la technique de la cire perdue...</p>
                    <a href="#" class="read-more">Lire l'article</a>
                </div>
            </article>
            <article class="blog-card">
                <div class="blog-img"
                    style="background-image: url('https://images.unsplash.com/photo-1513364776144-60967b0f800f?q=80&w=800');">
                </div>
                <div class="blog-content">
                    <span class="tag">Portrait</span>
                    <h3>Awa Ndongo : La nouvelle vague du Digital Art</h3>
                    <p>Rencontre avec l'artiste qui fusionne les motifs traditionnels Sawa et l'art numérique.</p>
                    <a href="#" class="read-more">Lire l'article</a>
                </div>
            </article>
        </div>
    </section>

@endsection
