{{-- Fiche détail + avis --}}


@extends('layouts.app')

@section('title', 'ARTSHOP | ' . $oeuvre->titre)

@section('content')

    <style>

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;

        }

        @media(max-width: 850px){
            .grid {
                display: grid;
                grid-template-columns: 1fr;
            }
        }
    </style>

        <div style="padding: 60px 5%; max-width: 1200px; margin: 0 auto;">

            {{-- Details oeuvre --}}
            <div class="grid">
                {{-- Image --}}
                <div>
                    <img src="{{ $oeuvre->image_url }}" alt="{{ $oeuvre->titre }}"
                        style="width: 100%; border-radius: 15px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);">

                    @if ($oeuvre->images->count())

                        <div style="display: flex; gap: 10px; margin-top: 15px;">
                            @foreach ($oeuvre->images as $img)

                                <img src="{{ asset('storage/' . $img->chemin) }}" alt=""
                                    style="width:80px; height:80px; object-fit:cover; border-radius:8px; cursor:pointer;"
                                >

                            @endforeach
                        </div>


                    @endif
                </div>

                {{-- Infos --}}

                <div>
                    <span style="background:  var(--accent); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem;">
                        {{ $oeuvre->categorie->name }}
                    </span>

                    <h1 style="font-family: 'Playfair Display',serif;font-size:2.2rem;margin:15px 0 10px;">
                        {{ $oeuvre->titre }}
                    </h1>
                    <p style="color:#666;margin-bottom:20px;">
                        Par <strong>{{ $oeuvre->artiste->name }}</strong>
                        @if ($oeuvre->artiste->bio)

                            — {{ \Illuminate\Support\Str::limit($oeuvre->artiste->bio, 60) }}

                        @endif
                    </p>

                    {{-- Note moyenne --}}
                    @if ($oeuvre->reviews->count())

                        <div style="margin-bottom: 15px">
                            @php
                              $moyenne = round($oeuvre->reviews->avg('note'));
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)

                                <i class="fa-{{ $i <= $moyenne ? 'solid' : 'regular' }} fa-star"
                                    style="color: var(--accent); font-size: 1.1rem;"></i>

                            @endfor
                            <span style="color: #666; font-size: 0.9rem; margin-left: 8px;">
                                {{ $moyenne }} / 5 ({{ $oeuvre->reviews->count() }} avis)
                            </span>
                        </div>

                    @endif

                    <div style="color: var(--primary); font-size: 2rem; margin-bottom: 25px; font-weight: 700;">
                        {{ number_format($oeuvre->price, 0, ',', ' ') }} FCFA
                    </div>

                    <p style="line-height:1.8;color:#444;margin-bottom:30px;">{{ $oeuvre->description }}</p>

                    <div style="display:flex;gap:10px;align-items:center;margin-bottom:15px;">
                        <span style="color:#666;font-size:0.9rem;">
                            <i class="fa-solid fa-eye">{{ number_format($oeuvre->vues) }} vues</i>
                        </span>

                        <span style="color: {{ $oeuvre->statut === 'disponible' ? 'green' : 'red' }}; font-size:0.9rem; margin-left:15px;">
                            <i class="fa-solid fa-circle" style="font-size:0.6rem;"></i>
                            {{ $oeuvre->statut === 'disponible' ? 'Disponible' : 'Indisponible' }}
                        </span>
                    </div>

                    @auth
                        @if ($oeuvre->statut === 'disponible')

                            <form action="{{ route('cart.add', $oeuvre) }}" method="POST">
                                @csrf

                                <button type="submit" class="btn-primary" style="width:100%;padding:15px;font-size:1rem;">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                    Ajouter au panier
                                </button>
                            </form>
                        @else
                            <button class="btn-primary" disabled style="width:100%;padding:15px;opacity:0.5;cursor:not-allowed;">
                                Œuvre indisponible
                            </button>

                        @endif

                    @else

                        <a href="{{ route('login') }}" class="btn-primary" style="display: block; text-align: center; padding: 15px;">
                            <i class="fa-solid fa-lock"></i>
                            Connectez-vous pour acheter
                        </a>

                    @endauth
                </div>
            </div>

            {{-- Section Avis --}}

            <div style="margin-top:70px;border-top:1px solid #eee;padding-top:50px;">
                <h2 style="font-family:'Playfair Display',serif;margin-bottom:30px;">
                    Avis des acheteurs

                </h2>

                @auth
                    <form action="{{ route('oeuvres.review', $oeuvre) }}" method="POST"
                        style="background:#f9f9f9;padding:25px;border-radius:12px;margin-bottom:30px;">
                        @csrf

                        <h4 style="margin-bottom:15px;">Laisser un avis</h4>

                        <div style="display:flex;gap:10px;margin-bottom:15px;align-items:center;">
                            <label>Note :</label>

                            @for($i = 1; $i <= 5; $i++)
                                <label style="cursor:pointer;">
                                    <input type="radio" name="note" value="{{ $i }}" style="display:none;">
                                    <i class="fa-regular fa-star" style="font-size:1.5rem;color:var(--accent);"></i>
                                </label>
                            @endfor

                        </div>
                        <textarea name="commentaire" placeholder="Partagez votre expérience..."
                            style="width:100%;padding:12px;border:1px solid #ddd;border-radius:8px;min-height:100px;resize:vertical;"></textarea>
                        <button type="submit" class="btn-primary" style="margin-top:12px;">Publier l'avis</button>
                    </form>
                @endauth

                @forelse ($oeuvre->reviews as $review)

                    <div style="border-bottom:1px solid #eee;padding:20px 0;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                            <strong>{{ $review->user->name }}</strong>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-{{ $i <= $review->note ? 'solid' : 'regular' }} fa-star"
                                        style="color:var(--accent);font-size:0.9rem;"></i>
                                @endfor
                            </div>
                        </div>
                        @if($review->commentaire)
                            <p style="color:#555;">{{ $review->commentaire }}</p>
                        @endif
                        <small style="color:#aaa;">{{ $review->created_at->diffForHumans() }}</small>
                    </div>

                @empty
                    <p style="color:#999;font-style:italic;">
                        Aucun avis pour cette œuvre. Soyez le premier !
                    </p>
                @endforelse

                {{-- Œuvres similaires --}}
                @if($similaires->count())
                    <div style="margin-top:70px;border-top:1px solid #eee;padding-top:50px;">
                        <h2 style="font-family:'Playfair Display',serif;margin-bottom:30px;">Œuvres similaires</h2>
                        <div class="product-grid">

                            @foreach($similaires as $sim)
                                <div class="product-card">
                                    <div class="product-img-container">

                                        <img src="{{ $sim->image_url }}" alt="{{ $sim->titre }}" class="product-img">
                                        <div class="card-actions">
                                            <a href="{{ route('oeuvres.show', $sim->slug) }}" class="btn-card btn-detail-view"
                                                onclick="openProduct({{ $sim->id }}})" style="text-decoration: none">
                                                <i class="fa-solid fa-eye"></i> Détails
                                            </a>
                                            @auth
                                                <form action="{{ route('cart.add', $sim) }}" method="POST">
                                                    @csrf

                                                    <button class="btn-card btn-quick-add" title="Ajouter au panier" type="submit">
                                                        <i class="fa-solid fa-bag-shopping"></i> + Panier
                                                    </button>
                                                </form>
                                            @endauth
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h3>{{ $sim->titre }}</h3>
                                        <p>Par {{ $sim->artiste->name }}</p>
                                        <div class="price">{{ number_format($sim->price, 0, ',', ' ') }} FCFA</div>
                                        {{-- <a href="{{ route('oeuvres.show', $sim->slug) }}" class="btn-primary"
                                            style="display:block;text-align:center;margin-top:10px;padding:8px;">
                                            Voir l'œuvre
                                        </a> --}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
        </div>

@endsection
