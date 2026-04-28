{{--  Historique commandes --}}

@extends('layouts.app')

@section('title', 'Mes commandes | ARTSHOP')

@section('content')

    <div style="padding:60px 5%;max-width:1000px;margin:0 auto;">
        <h2 style="font-family: 'Playfair Display',serif;margin-bottom:40px;">
            <i class="fa-solid fa-fa-box"></i>
            Mes Commandes
        </h2>

        @forelse ($commandes as $commande)

                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
                        <div>
                            <strong>Commande #{{ $commande->id }}</strong>
                            <span style="padding:4px 12px;border-radius:20px;font-size:0.8rem;font-weight:600;
                                background: {{ match ($commande->statut) {
        'payee' => '#d4edda', 'livree' => '#cce5ff',
        'annulee' => '#f8d7da', default => '#fff3cd'
    } }};

                                color:{{ match ($commande->statut) {
        'payee' => '#155724', 'livree' => '#004085',
        'annulee' => '#721c24', default => '#856404'
    } }};">

                                    {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                </span>

                                <strong style="color:var(--primary);">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</strong>
                        </div>
                    </div>

                    {{-- Articles --}}
                    <div  style="display:flex;gap:10px;flex-wrap:wrap;">

                        @foreach ($commande->items as $item)

                            <div style="display:flex;align-items:center;gap:10px;background:#f9f9f9;padding:8px 12px;border-radius:8px;">

                                <img src="{{ $item->oeuvre->image }}" alt=""
                             style="width:40px;height:40px;object-fit:cover;border-radius:5px;">

                                <div>
                            <div style="font-size:0.85rem;font-weight:600;">{{ $item->oeuvre->titre }}</div>
                            <div style="font-size:0.8rem;color:#666;">{{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA</div>

                            </div>

                        @endforeach
                    </div>

                    <div style="margin-top:15px;">
                          <a href="{{ route('commande.show', $commande) }}" style="color:var(--accent);font-size:0.9rem;text-decoration:none;">
                                Voir le détail <i class="fa-solid fa-arrow-right"></i>
                           </a>
                    </div>
        </div>

        @empty

            <div style="text-align:center;padding:80px;background:#f9f9f9;border-radius:15px;">
                <i class="fa-solid fa-box-open" style="font-size:4rem;color:#ddd;display:block;margin-bottom:20px;"></i>
                <p style="color:#999;">Vous n'avez pas encore passé de commande.</p>
                <a href="{{ route('oeuvres.index') }}" class="btn-primary" style="margin-top:20px;display:inline-block;">
                    Découvrir les œuvres
                </a>
            </div>

        @endforelse

        <div style="margin-top:30px;">{{ $commandes->links() }}</div>
    </div>

@endsection
