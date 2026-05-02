{{-- Catalogue avec filtres --}}

@extends('layouts.app')

@section('title', 'Boutique | ARTSHOP')

@section('content')


    <div style="padding: 60px 5%;">
        <h2 class="section-title" style="margin-bottom: 30px;">
            Catalogue des Œuvres
        </h2>

        {{-- Filtre & Recherche --}}

        <form action="{{ route('oeuvres.index') }}" method="GET"
            style="display: flex;gap: 15px; flex-wrap: wrap; margin-bottom: 40px; align-items: center;">

            <input type="text" name="search" placeholder="Rechercher une Œuvre..." value="{{ request('search') }}"
                    style="padding:10px 16px;border:1px solid #ddd;border-radius:20px;flex:1;min-width:200px;"
            >

            <select name="categorie" style="padding: 10px 16px; border: 1px solid #ddd; border-radius: 20px;">
                <option value="">Toutes Categories</option>

                @foreach ($categories as $categorie)

                    <option value="{{ $categorie->slug }}" {{ request('categorie') == $categorie->slug ? 'selected' : '' }}>
                        {{ $categorie->name }}
                    </option>

                @endforeach
            </select>

            <input type="number" name="prix_min" placeholder="Prix min (FCFA)" value="{{ request('prix_min') }}"
                    style="padding: 10px 16px; border: 1px solid #ddd; border-radius: 20px; width: 160px;">

            <input type="number" name="prix_max" placeholder="Prix max (FCFA)" value="{{ request('prix_max') }}"
                style="padding:10px 16px;border:1px solid #ddd;border-radius:20px;width:160px;">

            <button type="submit" class="btn-primary" style="color: #fff; font-weight: 700;">Filter</button>

            @if (request()->anyFilled(['search', 'categorie', 'prix_min', 'prix_max']))
                <a href="{{ route('oeuvres.index') }}" style="color:#666;text-decoration:none;">Réinitialiser</a>
            @endif
        </form>

        {{-- Grille --}}
        <div class="product-grid">

            @forelse ($oeuvres as $oeuvre)

                <div class="product-card">
                    <div class="product-img-container">

                        <img src="{{ $oeuvre->image_url }}" alt="{{ $oeuvre->titre }}" class="product-img">
                        <div class="card-actions">
                            <a href="{{ route('oeuvres.show', $oeuvre->slug) }}" class="btn-card btn-detail-view"
                                onclick="openProduct({{ $oeuvre->id }}})" style="text-decoration: none">
                                <i class="fa-solid fa-eye"></i> Détails
                            </a>
                            @auth
                                <form action="{{ route('cart.add', $oeuvre) }}" method="POST">
                                    @csrf

                                    <button class="btn-card btn-quick-add" title="Ajouter au panier" type="submit">
                                        <i class="fa-solid fa-bag-shopping"></i> + Panier
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>

                    <div class="product-info">

                        <small>{{ $oeuvre->categorie->name }}</small>
                        <h3>{{ $oeuvre->titre }}</h3>
                        <p>Par {{ $oeuvre->artiste->name }}</p>
                        <div class="price">{{ number_format($oeuvre->price, 0, ',', ' ') }} FCFA</div>

                        {{-- <div style="display: flex; gap: 10px; margin-top: 12px;">
                            <a href="{{ route('oeuvres.show', $oeuvre->slug) }}" class="btn-primary"
                                style="flex: 1; text-align: center; padding: 8px;"
                            >
                                Voir l'œuvre
                            </a>

                            @auth
                                <form action="{{ route('cart.add', $oeuvre) }}" method="POST">
                                    @csrf

                                    <button type="submit" class="btn-add" style="padding: 8px 14px;">
                                        <i class="fa-solid fa-bag-shopping"></i>
                                    </button>
                                </form>
                            @endauth
                        </div> --}}
                    </div>
                </div>

            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 60px; color: #666;">
                    <i class="fa-solid fa-palette" style="font-size:3rem;margin-bottom:15px;display:block;opacity:0.3;"></i>
                    <p>Aucune œuvre ne correspond à vos critères.</p>
                    <a href="{{ route('oeuvres.index') }}" class="btn-primary" style="margin-top: 15px; display: inline-block; text-decoration: none; color: #fff;">
                        Voir tout le catalogue
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div style="margin-top: 40px;">
            {{ $oeuvres->links() }}
        </div>
    </div>
@endsection
