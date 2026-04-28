{{--  Gestion utilisateurs + changement de rôle --}}

@extends('layouts.admin')

@section('title', 'Gestion Utilisateurs | ARTSHOP')

@section('content')

    <div style="padding: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">

            <h2 style="font-size: 1.4rem; font-weight: 700;">
                <i class="fa-solid fa-users-gear" style="color: var(--admin-accent)"></i>
                Gestion des utilsateurs
            </h2>

            <span style="background: #f1f5f9; padding: 6px 14px; border-radius:20px; font-size: 0.85rem; color: #64748b;">
                {{ $users->total() }} utilisateurs au total
            </span>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h3>Liste des membres</h3>

        </div>
        <table>
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Œuvres</th>
                    <th>Commandes</th>
                    <th>Inscrit le</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>

                @forelse ($users as $user)

                                                    <tr>
                                                        <td>
                                                            <div style="display:flex;align-items:center;gap:10px;">
                                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=e58e26&color=fff&size=36" alt=""
                                                                    style="width: 36px; height: 36px; border-radius: 50%;"
                                                                >
                                                                <div>
                                                                    <div style="font-weight:600;">
                                                                        {{ $user->name }}
                                                                    </div>

                                                                    @if ($user->bio)

                                                                        <div style="font-size: 0.75rem; color: #999;">
                                                                            {{ \Illuminate\Support\Str::limit($user->bio, 35) }}
                                                                        </div>

                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </td>

                                                        <td style="color: #64748b; font-size: 0.9rem;">{{ $user->email }}</td>

                                                        <td>
                                                            {{-- Changer de role --}}

                                                            <form action="{{ route('admin.users.role', $user) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')

                                                                <select name="role" onchange="this.form.submit()"
                                                                    style="padding: 4px 8px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.8rem; cursor: pointer;
                                                                        background: {{ match ($user->role) {
                        'admin' => '#dbeafe', 'artiste' => '#fef3c7',
                        default => '#f1f5f9'
                    } }}"
                                                                >
                                                                    <option value="client" {{ $user->role === 'client' ? 'selected' : '' }}>Client</option>
                                                                    <option value="artiste" {{ $user->role === 'artiste' ? 'selected' : '' }}>Artiste</option>
                                                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                                </select>
                                                            </form>
                                                        </td>

                                                        <td style="text-align: center">{{ $user->oeuvres_count }}</td>

                                                        <td style="text-align: center">{{ $user->commandes_count }}</td>

                                                        <td style="color: #64748b; font-size: 0.85rem;">
                                                            {{ $user->created_at->format('d/m/Y') }}
                                                        </td>

                                                        <td>
                                                            @if (!$user->isAdmin())

                                                            <form action="{{ route('admin.users.destroy',$user) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit" style="background:#fee2e2;color:#dc2626;border:none;padding:6px 12px;border-radius:6px;cursor:pointer;font-size:0.8rem;">
                                                                    <i class="fa-solid fa-trash"></i>Supprimer
                                                                </button>
                                                            </form>

                                                        @else

                                                            <span style="color:#aaa;font-size:0.8rem;font-style:italic;">Protégé</span>

                                                        @endif
                                                        </td>
                                                    </tr>

                @empty

                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                        Aucun utilisateur trouvé
                    </td>
                </tr>

                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}

    <div style="margin-top: 20px">
        {{ $users->links() }}
    </div>

@endsection
