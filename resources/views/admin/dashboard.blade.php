{{-- Tableau de bord admin + KPIs --}}

@extends('layouts.admin')

@section('title', 'Tableau bord | ARTSHOP Admin')

@section('content')

    {{-- KPI Cards --}}

    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-info">
                <h3>{{ number_format($stats['revenus'], 0, ',', ' ') }} FCFA</h3>
                <p>Revenus Mensuels</p>
            </div>
            <i class="fa-solid fa-chart-line color-1"></i>
        </div>
        <div class="kpi-card">
            <div class="kpi-info">
                <h3>{{ number_format($stats['utilisateurs']) }}</h3>
                <p>Utilisateurs Actifs</p>
            </div>
            <i class="fa-solid fa-user-group color-2"></i>
        </div>
        <div class="kpi-card">
            <div class="kpi-info">
                <h3>{{ $stats['ventes'] }}</h3>
                <p>Ventes ce mois</p>
            </div>
            <i class="fa-solid fa-bag-shopping color-3"></i>
        </div>
    </div>

    {{-- Table d'activites --}}

    <section class="admin-content" id="main-view">
        <div class="table-container">
            <div class="table-header">
                <h3>Dernières Activités</h3>

                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('admin.users.index') }}" class="btn-export" style="text-decoration: none">
                        <i class="fa-solid fa-users"></i> Gérer utilisateurs
                    </a>
                </div>

                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('admin.oeuvres.index') }}" class="btn-export" style="text-decoration: none">
                        <i class="fa-solid fa-palette"></i> Gérer œuvres
                    </a>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Rôle</th>
                        <th>Action</th>
                        <th>Date</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($activites as $activite)

                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e58e26&color=fff&size=32" alt="" style="width:32px;height:32px;border-radius:50%;">
                                    {{ $activite->user->name ?? 'Utilisateur supprimé' }}
                                </div>
                            </td>

                            <td>
                                <span style="padding:3px 10px;border-radius:20px;font-size:0.75rem;font-weight:600;
                                    background:{{ match($activite->user->role ?? '') {
                                        'admin'   => '#dbeafe', 'vendeur' => '#fef3c7',
                                        default   => '#f1f5f9'
                                    } }};
                                    color:{{ match($activite->user->role ?? '') {
                                        'admin'   => '#1e40af', 'vendeur' => '#92400e',
                                        default   => '#475569'
                                    } }};">
                                    {{ ucfirst($activite->user->role ?? '-') }}
                                </span>
                            </td>
                            <td>
                                    {{ $activite->action }}
                            </td>

                            <td>{{ $activite->created_at->format('d/m/y H:i') }}</td>

                            <td>
                                <span class="status-tag {{ in_array($activite->statut, ['payee', 'livree']) ? 'active' : 'pending' }}">
                                    {{ ucfirst(str_replace('_', ' ', $activite->statut)) }}
                                </span>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #999;">
                                Aucune activité recente.
                            </td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

@endsection
