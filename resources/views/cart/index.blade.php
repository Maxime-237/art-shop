{{--  Panier + formulaire commande --}}

@extends('layouts.app')

@section('title', 'Mon Panier | ARTSHOP')

@section('content')

    <div style="padding:60px 5%;max-width:1100px;margin:0 auto;">
        <h2 style="font-family:'Playfair Display',serif;margin-bottom:40px;">
            <i class="fa-solid fa-bag-shopping"></i>
            Mon Panier
        </h2>

        @if(empty($panier))
            <div style="text-align:center;padding:80px;background:#f9f9f9;border-radius:15px;">
                <i class="fa-solid fa-bag-shopping" style="font-size:4rem;color:#ddd;display:block;margin-bottom:20px;"></i>

                <p style="color:#999;font-size:1.1rem;">Votre panier est vide.</p>

                <a href="{{ route('oeuvres.index') }}" class="btn-primary" style="margin-top:20px;display:inline-block;">
                    Découvrir les œuvres
                </a>
            </div>
        @else

            <div style="display:grid;grid-template-columns:1fr 350px;gap:40px;align-items:start;">

                {{-- Liste articles --}}
                <div>
                    @foreach($panier as $id => $item)
                        <div
                            style="display:flex;gap:20px;padding:20px;background:white;border-radius:12px;box-shadow:0 3px 10px rgba(0,0,0,0.06);margin-bottom:15px;align-items:center;">

                            <img src="{{ $item['image'] }}" alt="{{ $item['titre'] }}"
                                style="width:90px;height:90px;object-fit:cover;border-radius:10px;">

                            <div style="flex:1;">
                                <h4 style="margin-bottom:4px;">{{ $item['titre'] }}</h4>
                                <p style="color:#666;font-size:0.9rem;margin-bottom:8px;">Par {{ $item['artiste'] }}</p>
                                <span style="font-weight:700;color:var(--primary);">
                                    {{ number_format($item['price'], 0, ',', ' ') }} FCFA × {{ $item['quantite'] }}
                                </span>
                            </div>

                            <div style="text-align:right;">
                                <div style="font-size:1.1rem;font-weight:700;color:var(--primary);margin-bottom:10px;">
                                    {{ number_format($item['price'] * $item['quantite'], 0, ',', ' ') }} FCFA
                                </div>
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf @method('DELETE')

                                    <button type="submit"
                                        style="background:none;border:none;color:#dc3545;cursor:pointer;font-size:0.85rem;">
                                        <i class="fa-solid fa-trash"></i>
                                        Retirer
                                    </button>

                                </form>
                            </div>
                        </div>
                    @endforeach

                    <form action="{{ route('cart.clear') }}" method="POST" style="margin-top:10px;">
                        @csrf @method('DELETE')
                        <button type="submit"
                            style="background:none;border:1px solid #dc3545;color:#dc3545;padding:8px 16px;border-radius:8px;cursor:pointer;">
                            <i class="fa-solid fa-trash-can"></i>
                            Vider le panier
                        </button>
                    </form>
                </div>

                {{-- Résumé & Commande --}}
                <div
                    style="background:white;padding:30px;border-radius:15px;box-shadow:0 5px 20px rgba(0,0,0,0.08);position:sticky;top:90px;">
                    <h3 style="margin-bottom:25px;font-family:'Playfair Display',serif;">Résumé</h3>

                    @foreach($panier as $item)
                        <div style="display:flex;justify-content:space-between;margin-bottom:10px;font-size:0.9rem;color:#555;">
                            <span>{{ Str::limit($item['titre'], 25) }}</span>
                            <span>{{ number_format($item['price'] * $item['quantite'], 0, ',', ' ') }} FCFA</span>
                        </div>
                    @endforeach

                    <hr style="margin:20px 0;">
                    <div style="display:flex;justify-content:space-between;font-size:1.2rem;font-weight:700;">
                        <span>Total</span>
                        <span style="color:var(--primary);">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                    </div>

                    <form action="{{ route('commande.store') }}" method="POST" style="margin-top:25px;">
                        @csrf
                        <div style="margin-bottom:15px;">
                            <label style="display:block;margin-bottom:6px;font-weight:600;">Adresse de livraison</label>
                            <input type="text" name="adresse_livraison" placeholder="Ex: Akwa, Douala, Cameroun" required
                                style="width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;">
                            @error('adresse_livraison')<small style="color:red;">{{ $message }}</small>@enderror
                        </div>
                        <button type="submit" class="btn-primary" style="width:100%;padding:14px;font-size:1rem;">
                            <i class="fa-solid fa-lock"></i>
                            Passer la commande
                        </button>
                    </form>
                </div>

            </div>
        @endif
    </div>



@endsection
