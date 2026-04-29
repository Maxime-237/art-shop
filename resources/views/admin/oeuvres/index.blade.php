{{-- Gestion catalogue + changement statut --}}

@extends('layouts.admin')

@section('title', 'Catalogue Produits | ARTSHOP Admin')

@section('content')

    <div style="padding:30px; margin-top: 2vh;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;">

            <h2 style="font-size:1.4rem;font-weight:700;">
                <i class="fa-solid fa-box-open" style="color:var(--admin-accent);"></i>
                Catalogue des Œuvres
            </h2>
            <span style="background:#f1f5f9;padding:6px 14px;border-radius:20px;font-size:0.85rem;color:#64748b;">
                {{ $oeuvres->total() }} œuvres au total
            </span>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h3>Toutes les œuvres</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Œuvre</th>
                        <th>Artiste</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Vues</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($oeuvres as $artwork)
                                    <tr>
                                        <td>
                                            <div style="display:flex;align-items:center;gap:12px;">
                                                <img src="{{ $artwork->image }}" alt="{{ $artwork->titre }}"
                                                    style="width:50px;height:50px;object-fit:cover;border-radius:8px;">
                                                <div>

                                                    <div style="font-weight:600;font-size:0.9rem;">
                                                        {{ Str::limit($artwork->titre, 30) }}
                                                    </div>

                                                    <div style="font-size:0.75rem;color:#999;">
                                                        Ajouté le {{ $artwork->created_at->format('d/m/Y') }}
                                                    </div>

                                                </div>
                                            </div>
                                        </td>
                                        <td style="font-size:0.9rem;">{{ $artwork->artiste->name }}</td>
                                        <td>
                                            <span style="background:#f1f5f9;padding:3px 10px;border-radius:20px;font-size:0.8rem;">
                                                {{ $artwork->categorie->name }}
                                            </span>
                                        </td>
                                        <td style="font-weight:600;color:var(--admin-accent);">
                                            {{ number_format($artwork->price, 0, ',', ' ') }} FCFA
                                        </td>
                                        <td style="text-align:center;color:#64748b;">
                                            <i class="fa-solid fa-eye" style="font-size:0.75rem;"></i>
                                            {{ number_format($artwork->vues) }}
                                        </td>
                                        <td>
                                            {{-- Changer le statut --}}
                                            <form action="{{ route('admin.oeuvres.statut', $artwork) }}" method="POST">
                                                @csrf @method('PUT')

                                                <select name="statut" onchange="this.form.submit()" style="padding:4px 8px;border:1px solid #e2e8f0;border-radius:6px;font-size:0.8rem;cursor:pointer;
                                                                    background:{{ match ($artwork->statut) {
                                                                        'disponible' => '#dcfce7', 'vendu' => '#dbeafe',
                                                                        default => '#fee2e2'
                                                                    } }};
                                                                                                                color:{{ match ($artwork->statut) {
                                                                        'disponible' => '#166534', 'vendu' => '#1e40af',
                                                                        default => '#dc2626'
                                                                    } }};"
                                                >

                                                    <option value="disponible" {{ $artwork->statut === 'disponible' ? 'selected' : '' }}>Disponible</option>

                                                    <option value="vendu" {{ $artwork->statut === 'vendu' ? 'selected' : '' }}>Vendu</option>

                                                    <option value="archive" {{ $artwork->statut === 'archive' ? 'selected' : '' }}>Archivé
                                                    </option>

                                                </select>
                                            </form>

                                        </td>

                                        <td>
                                            <div style="display:flex;gap:8px;align-items:center;">
                                                <a href="{{ route('oeuvres.show', $artwork->slug) }}" target="_blank"
                                                    style="background:#f1f5f9;color:#475569;border:none;padding:6px 10px;border-radius:6px;text-decoration:none;font-size:0.8rem;">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>

                                                <form action="{{ route('admin.oeuvres.destroy', $artwork) }}" method="POST"
                                                    onsubmit="return confirm('Supprimer définitivement « {{ $artwork->titre }} » ?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        style="background:#fee2e2;color:#dc2626;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;font-size:0.8rem;">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:40px;color:#999;">
                                Aucune œuvre dans le catalogue.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="margin-top:20px;">
            {{ $oeuvres->links() }}
        </div>
    </div>

@endsection
