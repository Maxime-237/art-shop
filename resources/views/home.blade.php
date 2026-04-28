{{-- PAGE D'ACCUEIL --}}

@extends('layouts.app')

@section('title', 'ArtSHOP | Marketplace d\'Excellence')

@section('content')

    {{-- HERO --}}
    <header class="hero" id="home">
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
                <a href="{{ route('oeuvres.index') }}" class="filter-btn active">Tous</a>
                @foreach($categories as $category)
                    <a href="{{ route('oeuvres.index', ['categorie' => $category->slug]) }}" class="filter-btn">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="product-grid">
            @forelse($oeuvres as $artwork)
                <div class="product-card">
                    <img src="{{ $artwork->image }}" alt="{{ $artwork->titre }}" class="product-img">
                    <div class="product-info">
                        <small>{{ $artwork->categorie->name }}</small>
                        <h3>{{ $artwork->titre }}</h3>
                        <p>Par {{ $artwork->artiste->name }}</p>
                        <div class="price">{{ number_format($artwork->prix, 0, ',', ' ') }} FCFA</div>
                        <div style="display:flex;gap:10px;margin-top:12px;">
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
                        </div>
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
