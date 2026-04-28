<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::withCount(['oeuvres', 'commandes'])
                    ->latest()
                    ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user) {
        $request->validate([
            'role' => 'required|in:client,artiste,admin'
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'Rôle de '. $user->name . ' mis à jour avec succès !');
    }

    public function destroy(User $user) {

        abort_if($user->isAdmin(), 403, 'Vous ne pouvez pas supprimer un administrateur.');

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès !');
    }
}
