<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Commande;
use App\Models\CommandeItem;
use App\Models\Oeuvre;

class CommandeController extends Controller
{
    public function index() {
        // Code pour afficher les commandes de l'utilisateur

        $commandes = Auth::user()
            ->commandes()
            ->with('items.oeuvre')
            ->latest()
            ->paginate(10);


        return view('commandes.index', compact('commandes'));
    }

    public function store(Request $request) {
        // Code pour créer une nouvelle commande à partir du panier

        //validation de l'adresse de livraison
        $request->validate([
            'adresse_livraison' => 'required|string|max:255',
        ]);

        $panier = session()->get('panier', []);
        if(empty($panier)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        DB::transaction(function() use ($request, $panier) {
            $total = collect($panier)->sum(fn($item) =>
                $item['price'] * $item['quantite']
            );

            $commande = Commande::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'statut' => 'en_attente',
                'adresse_livraison' => $request->adresse_livraison,
            ]);

            foreach($panier as $oeuvreId => $item) {
                CommandeItem::create([
                    'commande_id' => $commande->id,
                    'oeuvre_id' => $oeuvreId,
                    'quantite' => $item['quantite'],
                    'prix_unitaire' => $item['price']
                ]);

                 Oeuvre::where('id', $oeuvreId)->decrement('stock', $item['quantite']);

                 $oeuvre = Oeuvre::find($oeuvreId);
                if ($oeuvre && $oeuvre->stock <= 0) {
                    $oeuvre->update(['statut' => 'vendu']);
                }
            }
            session()->forget('panier');
        });

        return redirect()->route('commande.index')->with('success', 'Votre commande a été passée avec succès ! 🎉');

    }

    public function show(Commande $commande) {
        // Code pour afficher les détails d'une commande

        abort_if($commande->user_id !== Auth::id(), 403);
        $commande->load('items.oeuvre.artiste');

        return view('commandes.show', compact('commande'));
    }
}
