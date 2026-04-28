<?php

namespace App\Http\Controllers;

use App\Models\Oeuvre;
use Illuminate\Http\Request;

class CartController extends Controller
{
        public function index() {
            // Code pour afficher le panier

            $panier = session()->get('panier', []);
            $total = collect($panier)->sum(fn($item) =>
                $item['price'] * $item['quantite']
            );

            return view('cart.index', compact('panier', 'total'));
        }

        public function add(Oeuvre $oeuvre) {
            // Code pour ajouter une œuvre au panier

            if($oeuvre->statut !== 'disponible') {
                return redirect()->back()->with('error', 'Cette œuvre n\'est pas disponible.');
            }

            $panier = session()->get('panier', []);

            if(isset($panier[$oeuvre->id])) {
                $panier[$oeuvre->id]['quantite']++;
            } else {
                $panier[$oeuvre->id] = [
                    'titre' => $oeuvre->titre,
                    'price' => $oeuvre->price,
                    'image' => $oeuvre->image,
                    'artiste' => $oeuvre->artiste->name,
                    'quantite' => 1
                ];
            }
            session()->put('panier', $panier);
            return redirect()->back()->with('success', '« ' . $oeuvre->titre . ' » ajoutée au panier.');
        }

        public function remove(Oeuvre $oeuvre) {
            // Code pour retirer une œuvre du panier

                $panier = session()->get('panier', []);


                unset($panier[$oeuvre->id]);
                session()->put('panier', $panier);


                return redirect()->back()->with('success', 'Œuvre retirée du panier.');

        }

        public function clear() {
            // Code pour vider le panier

            session()->forget('panier');
            return redirect()->back()->with('success', 'Panier vidé.');
        }
}
