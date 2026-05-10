<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OeuvreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\Artiste\ArtisteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminOeuvreController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Auth (Breeze)
require __DIR__.'/auth.php';

// ─── PUBLIC ────────────────────────────────────────────────────────────────────────────────

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/boutique', [OeuvreController::class, 'catalogue'])->name('oeuvres.index');
Route::get('/boutique/{slug}', [OeuvreController::class, 'show'])->name('oeuvres.show');

// ─── CLIENT (connecté) ─────────────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {
    //panier
    Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
    Route::post('/panier/{oeuvre}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/panier/{oeuvre}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/panier', [CartController::class, 'clear'])->name('cart.clear');

    // Commandes
    Route::post('/commande', [CommandeController::class, 'store'])->name('commande.store');
    Route::get('/commandes', [CommandeController::class, 'index'])->name('commande.index');
    Route::get('/commandes/{commande}', [CommandeController::class, 'show'])->name('commande.show');

    // Avis
    Route::post('/boutique/{oeuvre}/avis', [App\Http\Controllers\OeuvreController::class, 'addReview'])->name('oeuvres.review');
});

// ─── Artiste ──────────────────────────────────────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:artiste'])
    ->prefix('artiste')
    ->name('artiste.')
    ->group(function() {
    Route::get('/dashboard', [ArtisteController::class, 'dashboard'])->name('dashboard');
    // Autres routes pour l'artiste (gestion des œuvres, commandes, etc.)
    Route::post('/oeuvres', [ArtisteController::class, 'store'])->name('oeuvres.store');
    Route::get('/oeuvres/{oeuvre}/edit', [ArtisteController::class, 'edit'])->name('oeuvres.edit');
    Route::put('/oeuvres/{oeuvre}', [ArtisteController::class, 'update'])->name('oeuvres.update');
    Route::delete('/oeuvres/{oeuvre}', [ArtisteController::class, 'destroy'])->name('oeuvres.destroy');
});

// ─── ADMIN ──────────────────────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Gestion des utilisateurs
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.role');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Autres routes pour l'admin (gestion des Œuvres, catégories, commandes, etc.)
        Route::get('/oeuvres', [AdminOeuvreController::class, 'index'])->name('oeuvres.index');
        Route::put('/oeuvres/{oeuvre}/statut', [AdminOeuvreController::class, 'updateStatut'])->name('oeuvres.statut');
        Route::delete('/oeuvres/{oeuvre}', [AdminOeuvreController::class, 'destroy'])->name('oeuvres.destroy');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route page de login admin (accessible sans être connecté)
Route::get('/admin/login', function () {
    return view('admin.auth');
})->name('admin.login')->middleware('guest');

// Route temporaire pour créer l'admin - À SUPPRIMER APRÈS !
Route::get('/setup-admin', function () {
    $user = App\Models\User::where('email', 'admin@camerart.cm')->first();

    if ($user) {
        return 'Admin existe déjà ! Email: admin@camerart.cm';
    }

    App\Models\User::create([
        'name'     => 'Super Admin',
        'email'    => 'admin@camerart.cm',
        'password' => bcrypt('admin123'),
        'role'     => 'admin',
    ]);

    return 'Admin créé avec succès ! Email: admin@camerart.cm / MDP: admin123';
});
