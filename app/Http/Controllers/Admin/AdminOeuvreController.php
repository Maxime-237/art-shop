<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Oeuvre;
use App\Models\Categorie;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminOeuvreController extends Controller
{
        // Méthodes pour gérer les œuvres (CRUD)
        public function index() {
            // Code pour afficher la liste des œuvres

            $oeuvres = Oeuvre::with('artiste', 'categorie')->latest()->paginate(10);
            return view('admin.oeuvres.index', compact('oeuvres'));
        }

        public function updateStatut(Request $request, Oeuvre $oeuvre) {
            // Code pour mettre à jour le statut d'une œuvre

            $request->validate([
                'statut' => 'required|in:disponible,vendu,archive',
            ]);

            $oeuvre->update(['statut' => $request->statut]);

            return redirect()->back()->with('success', 'Statut de l\'œuvre mis à jour !');
        }

        public function destroy(Oeuvre $oeuvre) {
            // Code pour supprimer une œuvre

            $oeuvre->delete($oeuvre);
            return redirect()->route('admin.oeuvres.index')->with('success', 'Œuvre supprimée !');
        }
}
