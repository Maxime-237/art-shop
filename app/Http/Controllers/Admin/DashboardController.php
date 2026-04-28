<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Oeuvre;
use App\Models\Commande;
use App\Models\User;

class DashboardController extends Controller
{
    public function index() {

        $stats = [
            'revenus'            => Commande::where('statut', 'payee')
                                          ->whereMonth('created_at', now()->month)
                                          ->sum('total'),

            'utilisateurs'       => User::where('role', '!=', 'admin')->count(),
            'ventes'             => Commande::where('statut', 'payee')
                                        ->whereMonth('created_at', now()->month)
                                         ->count(),
            'oeuvres_en_attente' => Oeuvre::where('statut', 'disponible')->count()
        ];

        $activites = Commande::with('user')
                            ->latest()
                            ->take(15)
                            ->get()
                            ->map(fn($commande) => (object)[
                                'user' => $commande->user->name,
                                'action' => 'Commande #' . $commande->id . ' - ' . number_format($commande->total, 0, ';', ' ') . ' FCFA',
                                'statut' => $commande->statut,
                                'created_at' => $commande->created_at,
                            ]);

        return view('admin.dashboard', compact('stats', 'activites'));
    }
}
