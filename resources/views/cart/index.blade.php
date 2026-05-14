@extends('layouts.app')

@section('title', 'Mon Panier | ARTSHOP')

@section('content')

<div class="cart-page">
    <h2 class="cart-title">
        <i class="fa-solid fa-bag-shopping"></i> Mon Panier
    </h2>

    @if(empty($panier))
        <div class="cart-empty">
            <i class="fa-solid fa-bag-shopping cart-empty-icon"></i>
            <p>Votre panier est vide.</p>
            <a href="{{ route('oeuvres.index') }}" class="btn-primary">
                Découvrir les œuvres
            </a>
        </div>
    @else
        <div class="cart-layout">

            {{-- Liste articles --}}
            <div class="cart-items">
                @foreach($panier as $id => $item)
                    <div class="cart-item-row">
                        <img src="{{ $item['image'] }}"
                             alt="{{ $item['titre'] }}"
                             class="cart-item-img">
                        <div class="cart-item-info">
                            <h4 class="cart-item-title">{{ $item['titre'] }}</h4>
                            <p class="cart-item-artist">Par {{ $item['artiste'] }}</p>
                            <span class="cart-item-price">
                                {{ number_format($item['price'], 0, ',', ' ') }} FCFA × {{ $item['quantite'] }}
                            </span>
                        </div>
                        <div class="cart-item-total">
                            <div class="cart-item-subtotal">
                                {{ number_format($item['price'] * $item['quantite'], 0, ',', ' ') }} FCFA
                            </div>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="cart-remove-btn">
                                    <i class="fa-solid fa-trash"></i> Retirer
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <form action="{{ route('cart.clear') }}" method="POST" class="cart-clear-form">
                    @csrf @method('DELETE')
                    <button type="submit" class="cart-clear-btn">
                        <i class="fa-solid fa-trash-can"></i> Vider le panier
                    </button>
                </form>
            </div>

            {{-- Résumé --}}
            <div class="cart-summary">
                <h3 class="cart-summary-title">Résumé</h3>

                @foreach($panier as $item)
                    <div class="cart-summary-line">
                        <span>{{ Str::limit($item['titre'], 25) }}</span>
                        <span>{{ number_format($item['price'] * $item['quantite'], 0, ',', ' ') }} FCFA</span>
                    </div>
                @endforeach

                <hr class="cart-divider">

                <div class="cart-total-line">
                    <span>Total</span>
                    <span class="cart-total-amount">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                </div>

                <form action="{{ route('commande.store') }}" method="POST" class="cart-order-form">
                    @csrf
                    <div class="cart-address-group">
                        <label>Adresse de livraison</label>
                        <input type="text" name="adresse_livraison"
                               placeholder="Ex: Akwa, Douala, Cameroun" required>
                        @error('adresse_livraison')
                            <small class="cart-error">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn-primary cart-order-btn">
                        <i class="fa-solid fa-lock"></i> Passer la commande
                    </button>
                </form>
            </div>

        </div>
    @endif
</div>

@endsection

@push('styles')
<style>
.cart-page {
    padding: 60px 5%;
    max-width: 1100px;
    margin: 0 auto;
}

.cart-title {
    font-family: 'Playfair Display', serif;
    margin-bottom: 40px;
    font-size: 1.8rem;
}

/* Panier vide */
.cart-empty {
    text-align: center;
    padding: 80px 20px;
    background: #f9f9f9;
    border-radius: 15px;
}
.cart-empty-icon {
    font-size: 4rem;
    color: #ddd;
    display: block;
    margin-bottom: 20px;
}
.cart-empty p {
    color: #999;
    font-size: 1.1rem;
    margin-bottom: 20px;
}

/* Layout grille */
.cart-layout {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 40px;
    align-items: start;
}

/* Item */
.cart-item-row {
    display: flex;
    gap: 20px;
    padding: 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.06);
    margin-bottom: 15px;
    align-items: center;
}
.cart-item-img {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 10px;
    flex-shrink: 0;
}
.cart-item-info { flex: 1; min-width: 0; }
.cart-item-title {
    margin-bottom: 4px;
    word-break: break-word;
    font-size: 0.95rem;
}
.cart-item-artist {
    color: #666;
    font-size: 0.85rem;
    margin-bottom: 6px;
}
.cart-item-price {
    font-weight: 700;
    color: var(--primary);
    font-size: 0.9rem;
}
.cart-item-total {
    text-align: right;
    flex-shrink: 0;
}
.cart-item-subtotal {
    font-size: 1rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 10px;
    white-space: nowrap;
}
.cart-remove-btn {
    background: none;
    border: none;
    color: #dc3545;
    cursor: pointer;
    font-size: 0.85rem;
}

/* Vider */
.cart-clear-form { margin-top: 10px; }
.cart-clear-btn {
    background: none;
    border: 1px solid #dc3545;
    color: #dc3545;
    padding: 8px 16px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.9rem;
}

/* Résumé */
.cart-summary {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    position: sticky;
    top: 90px;
}
.cart-summary-title {
    font-family: 'Playfair Display', serif;
    margin-bottom: 20px;
    font-size: 1.3rem;
}
.cart-summary-line {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 0.9rem;
    color: #555;
}
.cart-divider { margin: 20px 0; }
.cart-total-line {
    display: flex;
    justify-content: space-between;
    font-size: 1.2rem;
    font-weight: 700;
}
.cart-total-amount { color: var(--primary); }

/* Formulaire commande */
.cart-order-form { margin-top: 25px; }
.cart-address-group { margin-bottom: 15px; }
.cart-address-group label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    font-size: 0.95rem;
}
.cart-address-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 0.95rem;
    box-sizing: border-box;
}
.cart-error { color: red; font-size: 0.8rem; }
.cart-order-btn {
    width: 100%;
    padding: 14px;
    font-size: 1rem;
}

/* ── RESPONSIVE ── */
@media (max-width: 900px) {
    .cart-layout {
        grid-template-columns: 1fr;
        gap: 25px;
    }
    .cart-summary {
        position: static;
    }
}

@media (max-width: 600px) {
    .cart-page { padding: 30px 4%; }
    .cart-title { font-size: 1.4rem; }

    .cart-item-row {
        flex-wrap: wrap;
        gap: 12px;
        padding: 15px;
    }
    .cart-item-img {
        width: 70px;
        height: 70px;
    }
    .cart-item-total {
        width: 100%;
        text-align: left;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .cart-item-subtotal { margin-bottom: 0; }
}
</style>
@endpush
