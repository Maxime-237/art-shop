<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oeuvre;
use App\Models\Categorie;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class OeuvreController extends Controller
{
    public function catalogue(Request $request) {
        // Code pour afficher le catalogue des œuvres

        $query = Oeuvre::with(['Categorie', 'Artiste'])
            ->where('statut', 'disponible');

        if($request->filled('categorie')) {
            $query->whereHas('Categorie', fn($q) =>
                $q->where('slug', $request->categorie)
            );
        }

        //trier les Oeuvres par prix
        if($request->filled('prix_min')) {
            $query->where('price', '>=', $request->prix_min);
        }


        if($request->filled('prix_max')) {
            $query->where('price', '<=', $request->prix_max);
        }

        //rechercher les Oeuvres par titre ou description

        if($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $oeuvres = $query->latest()->paginate(12)->withQueryString();
        $categories = Categorie::all();

        return view('oeuvres.index', compact('oeuvres', 'categories'));
    }

    public function show($slug) {
        // Code pour afficher les détails d'une œuvre

        $oeuvre = Oeuvre::with(['artiste', 'categorie', 'reviews.user', 'images'])
                ->where('slug', $slug)
                ->where('statut', 'disponible')
                ->firstOrFail();

        // Incrémenter le nombre de vues
        $oeuvre->vues = $oeuvre->vues + 1;
        $oeuvre->save();

        //Recherche des oeuvres similaires
        $similaires = Oeuvre::with(['artiste', 'categorie'])
            ->where('categorie_id', $oeuvre->categorie_id)
            ->where('id', '!=', $oeuvre->id)
            ->where('statut', 'disponible')
            ->latest()
            ->take(4)
            ->get();

        return view('oeuvres.show', compact('oeuvre', 'similaires'));
    }

    public function addReview(Request $request, Oeuvre $oeuvre) {
        // Code pour ajouter un avis à une œuvre


        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500'
        ]);

        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'oeuvre_id' => $oeuvre->id],
            ['note' => $request->note, 'commentaire' => $request->commentaire]
        );

        return redirect()->back()->with('success', 'Votre avis a été enregistré !');
    }
}
