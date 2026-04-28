<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Oeuvre;


class HomeController extends Controller
{
    public function index() {
        $oeuvres = Oeuvre::with(['categorie', 'artiste'])
            ->where('statut', 'disponible')
            ->latest()
            ->take(8)
            ->get();

        $categories = Categorie::withCount('oeuvres')->get();

        return view('home', compact('oeuvres', 'categories'));
    }
}
