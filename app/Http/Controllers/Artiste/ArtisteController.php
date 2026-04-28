<?php

namespace App\Http\Controllers\Artiste;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Oeuvre;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class ArtisteController extends Controller
{
    public function dashboard()
    {
        // Code pour afficher le tableau de bord de l'artiste

        $user = Auth::user();
        $oeuvres = $user->Oeuvre()->with('categorie')->latest()->get();
        $stats = [
            'ventes_totales' => $user->oeuvre()
                ->join('commande_items', 'oeuvres.id', '=', 'commande_items.oeuvre_id')
                ->sum('commande_items.prix_unitaire'),

            'vues' => $user->Oeuvre()->sum('vues'),
            'oeuvres' => $oeuvres->count(),
        ];

        $categories = Categorie::all();
        return view('artiste.dashboard', compact('oeuvres', 'stats', 'categories'));
    }

    public function store(Request $request)
    {
        // Code pour créer une nouvelle œuvre

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'categorie_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120'
        ]);

        $imagePath = $request->file('image')->store('oeuvres', 'public');

        Oeuvre::create([
            'user_id' => Auth::id(),
            'categorie_id' => $request->categorie_id,
            'titre' => $request->titre,
            'slug' => Str::slug($request->titre) . '-' . uniqid(),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath
        ]);
        return redirect()->route('artiste.dashboard')->with('success', 'Œuvre publiée avec succès ! 🎨');

    }

    public function edit(Oeuvre $oeuvre)
    {
        // Code pour afficher le formulaire d'édition d'une œuvre

        abort_if($oeuvre->user_id !== Auth::id(), 403);


        $categories = Categorie::all();
        return view('artiste.edit', compact('oeuvre', 'categories'));
    }
    public function update(Request $request, Oeuvre $oeuvre)
    {
        // Code pour mettre à jour une œuvre

        abort_if($oeuvre->user_id !== Auth::id(), 403);

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'categorie_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120'
        ]);

        $data = $request->only(['categorie_id', 'titre', 'description', 'price', 'stock']);

        // mise a jour de l'image
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($oeuvre->image);
            $imagePath = $request->file('image')->store('oeuvres', 'public');
            $oeuvre->update(['image' => $imagePath]);
        }

        $oeuvre->update($data);

        return redirect()->route('artiste.dashboard')->with('success', 'Œuvre mise à jour avec succès ! ✏️');
    }

    public function destroy(Oeuvre $oeuvre){
        //delete an artwork

        abort_if($oeuvre->user_id !== Auth::id(), 403);

        Storage::disk('public')->delete($oeuvre->image);
        $oeuvre->delete();

        return redirect()->route('artiste.dashboard')->with('success', 'Œuvre supprimée avec succès ! 🗑️');
    }

}
