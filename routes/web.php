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
use App\Models\Oeuvre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Auth (Breeze)
require __DIR__.'/auth.php';

// ─── PUBLIC ──────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/boutique', [OeuvreController::class, 'catalogue'])->name('oeuvres.index');
Route::get('/boutique/{slug}', [OeuvreController::class, 'show'])->name('oeuvres.show');

// ─── CLIENT (connecté) ───────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
    Route::post('/panier/{oeuvre}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/panier/{oeuvre}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/panier', [CartController::class, 'clear'])->name('cart.clear');

    Route::post('/commande', [CommandeController::class, 'store'])->name('commande.store');
    Route::get('/commandes', [CommandeController::class, 'index'])->name('commande.index');
    Route::get('/commandes/{commande}', [CommandeController::class, 'show'])->name('commande.show');

    Route::post('/boutique/{oeuvre}/avis', [OeuvreController::class, 'addReview'])->name('oeuvres.review');
});

// ─── ARTISTE ─────────────────────────────────────────────
Route::middleware(['auth'])->prefix('artiste')->name('artiste.')->group(function () {
    Route::get('/dashboard', function () {
        if (!Auth::user()->isArtiste()) abort(403);
        return app(ArtisteController::class)->dashboard();
    })->name('dashboard');

    Route::post('/oeuvres', function (\Illuminate\Http\Request $request) {
        if (!Auth::user()->isArtiste()) abort(403); // ← ! ajouté
        return app(ArtisteController::class)->store($request);
    })->name('oeuvres.store');

    Route::get('/oeuvres/{oeuvre}/edit', function ($oeuvre) {
        if (!Auth::user()->isArtiste()) abort(403);
        $oeuvreModel = Oeuvre::findOrFail($oeuvre);
        return app(ArtisteController::class)->edit($oeuvreModel);
    })->name('oeuvres.edit');

    Route::put('/oeuvres/{oeuvre}', function (\Illuminate\Http\Request $request, $oeuvre) {
        if (!Auth::user()->isArtiste()) abort(403);
        $oeuvreModel = Oeuvre::findOrFail($oeuvre);
        return app(ArtisteController::class)->update($request, $oeuvreModel);
    })->name('oeuvres.update');

    Route::delete('/oeuvres/{oeuvre}', function ($oeuvre) {
        if (!Auth::user()->isArtiste()) abort(403);
        $oeuvreModel = Oeuvre::findOrFail($oeuvre);
        return app(ArtisteController::class)->destroy($oeuvreModel);
    })->name('oeuvres.destroy');
});

// ─── ADMIN ───────────────────────────────────────────────
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        if (!Auth::user()->isAdmin()) abort(403);
        return app(DashboardController::class)->index();
    })->name('dashboard');

    Route::get('/users', function () {
        if (!Auth::user()->isAdmin()) abort(403);
        return app(UserController::class)->index();
    })->name('users.index');

    Route::put('/users/{user}/role', function (\Illuminate\Http\Request $request, $user) {
        if (!Auth::user()->isAdmin()) abort(403);
        return app(UserController::class)->updateRole($request, $user);
    })->name('users.role');

    Route::delete('/users/{user}', function ($user) {
        if (!Auth::user()->isAdmin()) abort(403); // ← ! ajouté
        return app(UserController::class)->destroy($user);
    })->name('users.destroy');

    Route::get('/oeuvres', function () {
        if (!Auth::user()->isAdmin()) abort(403);
        return app(AdminOeuvreController::class)->index();
    })->name('oeuvres.index');

    Route::put('/oeuvres/{oeuvre}/statut', function (\Illuminate\Http\Request $request, $oeuvre) {
        if (!Auth::user()->isAdmin()) abort(403);
        $oeuvreModel = Oeuvre::findOrFail($oeuvre);
        return app(AdminOeuvreController::class)->updateStatut($request, $oeuvreModel);
    })->name('oeuvres.statut');

    Route::delete('/oeuvres/{oeuvre}', function ($oeuvre) {
        if (!Auth::user()->isAdmin()) abort(403);
        $oeuvreModel = Oeuvre::findOrFail($oeuvre);
        return app(AdminOeuvreController::class)->destroy($oeuvreModel);
    })->name('oeuvres.destroy');
});

// ─── PROFILE ─────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── LOGIN ADMIN ─────────────────────────────────────────
Route::get('/admin/login', function () {
    return view('admin.auth');
})->name('admin.login')->middleware('guest');


