<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Oeuvre;
use App\Models\User;



class HomeController extends Controller
{
    public function index() {
        $oeuvres = Oeuvre::with(['categorie', 'artiste'])
            ->where('statut', 'disponible')
            ->latest()
            ->take(10)
            ->get();

        $categories = Categorie::withCount('oeuvres')->get();

        $users = User::withCount('oeuvres')
                ->where('role', 'artiste')
                ->take(4)
                ->get();


        return view('home', compact('oeuvres', 'categories', 'users'));
    }
}
