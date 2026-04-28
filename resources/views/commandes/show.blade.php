{{--  Detail d'une commandes --}}
@extends('layouts.app')

@section('title', 'Commande #' . $commande->id . ' | ARTSHOP')

@section('content')

    <div style="padding:60px 5%;max-width:900px;margin:0 auto;">

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:40px;">
            <h2 style="font-family:'Playfair Display',serif;">
                Commande <span style="color:var(--accent);">#{{ $commande->id }}</span>
            </h2>
            <a href="{{ route('commande.index') }}" style="color:#666;text-decoration:none;font-size:0.9rem;">
                <i class="fa-solid fa-arrow-left"></i> Mes commandes
            </a>
        </div>

        {{-- Infos commande --}}

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:35px;">

            <div style="background:white;padding:20px;border-radius:12px;box-shadow:0 3px 10px rgba(0,0,0,0.06);">
                <p style="color:#999;font-size:0.85rem;margin-bottom:5px;">Date de commande</p>
                <p style="font-weight:600;">{{ $commande->created_at->format('d/m/Y à H:i') }}</p>
            </div>

            <div style="background:white;padding:20px;border-radius:12px;box-shadow:0 3px 10px rgba(0,0,0,0.06);">

                <p style="color:#999;font-size:0.85rem;margin-bottom:5px;">Statut</p>
                <span style="padding:4px 14px;border-radius:20px;font-size:0.85rem;font-weight:600;
                    background:{{ match ($commande->statut) {
                        'payee' => '#d4edda', 'livree' => '#cce5ff',
                        'annulee' => '#f8d7da', default => '#fff3cd'
                    } }};
                                    color:{{ match ($commande->statut) {
                        'payee' => '#155724', 'livree' => '#004085',
                        'annulee' => '#721c24', default => '#856404'
                    } }};">
                    {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                </span>

            </div>

            <div style="background:white;padding:20px;border-radius:12px;box-shadow:0 3px 10px rgba(0,0,0,0.06);">
                <p style="color:#999;font-size:0.85rem;margin-bottom:5px;">Adresse de livraison</p>
                <p style="font-weight:600;">{{ $commande->adresse_livraison }}</p>
            </div>

            <div style="background:white;padding:20px;border-radius:12px;box-shadow:0 3px 10px rgba(0,0,0,0.06);">
                <p style="color:#999;font-size:0.85rem;margin-bottom:5px;">Total payé</p>
                <p style="font-weight:700;font-size:1.2rem;color:var(--primary);">
                    {{ number_format($commande->total, 0, ',', ' ') }} FCFA
                </p>
            </div>
        </div>

        {{-- Articles --}}
        <h3 style="font-family:'Playfair Display',serif;margin-bottom:20px;">Articles commandés</h3>

        @foreach($commande->items as $item)
            <div
                style="display:flex;gap:20px;background:white;padding:20px;border-radius:12px;box-shadow:0 3px 10px rgba(0,0,0,0.06);margin-bottom:15px;align-items:center;">
                <img src="{{ $item->oeuvre->image }}" alt="{{ $item->oeuvre->titre }}"
                    style="width:80px;height:80px;object-fit:cover;border-radius:10px;"
                >
                <div style="flex:1;">
                    <h4 style="margin-bottom:4px;">{{ $item->oeuvre->titre }}</h4>
                    <p style="color:#666;font-size:0.9rem;">Par {{ $item->oeuvre->artiste->name }}</p>
                    <p style="color:#aaa;font-size:0.85rem;">Qté : {{ $item->quantite }}</p>
                </div>

                <div style="text-align:right;">

                    <div style="font-weight:700;color:var(--primary);">
                        {{ number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') }} FCFA
                    </div>

                    <div style="color:#aaa;font-size:0.8rem;">
                        {{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA / unité
                    </div>

                    <a href="{{ route('oeuvres.show', $item->oeuvre->slug) }}"
                        style="color:var(--accent);font-size:0.85rem;text-decoration:none;margin-top:5px;display:inline-block;">
                        Voir l'œuvre →
                    </a>
                </div>
            </div>
        @endforeach

        {{-- Total récapitulatif --}}
        <div
            style="background:white;padding:25px;border-radius:12px;box-shadow:0 3px 10px rgba(0,0,0,0.06);margin-top:10px;">
            <div style="display:flex;justify-content:space-between;font-size:1.2rem;font-weight:700;">
                <span>Total</span>
                <span style="color:var(--primary);">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</span>
            </div>
        </div>

    </div>

@endsection
