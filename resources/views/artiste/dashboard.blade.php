{{-- Studio artiste + modal publication --}}

@extends('layouts.artiste')

@section('title', 'Artist Studio | ARTSHOP')

@section('content')

    <header class="admin-header">
        <div class="search-box">
            <i class="fa-solid fa-search"></i>
            <input type="text" placeholder="Rechercher une œuvre, un ID...">
        </div>
        <div class="admin-profile">
            <span class="status-indicator"></span>
            <p>{{ auth()->user()->name }}</p>
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=e58e26&color=fff"
                alt="Artiste">
        </div>
    </header>

    {{-- KPI Cards --}}

    <section class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-info">
                <p>Ventes totales</p>
                <h3>{{ number_format($stats['ventes_totales'], 0, ',', ' ') }} FCA</h3>
            </div>
            <i class="fa-solid fa-money-bill color-1"></i>
        </div>
        <div class="kpi-card">
            <div class="kpi-info">
                <p>Vues du profil</p>
                <h3>{{ number_format($stats['vues']) }}</h3>
            </div>
            <i class="fa-solid fa-eye color-2"></i>
        </div>
        <div class="kpi-card">
            <div class="kpi-info">
                <p>Œuvres publiées</p>
                <h3>{{ $stats['oeuvres'] }}</h3>
            </div>
            <i class="fa-solid fa-images color-3"></i>
        </div>
    </section>

    {{-- Portfolio --}}

    <div class="table-container">
        <div class="table-header">
            <h3>Mes Œuvres Récentes</h3>
            <button class="btn-upload" onclick="openUploadModal()">
                <i class="fa-solid fa-plus"></i> Publier
            </button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Prix</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($oeuvres as $oeuvre)
                    <tr>
                        <td><img src="{{ $oeuvre->image_url }}" alt="{{ $oeuvre->titre }}"
                                style="width:60px;height:60px;object-fit:cover;border-radius:8px;"></td>
                        <td><strong>{{ $oeuvre->titre }}</strong></td>
                        <td>{{ number_format($oeuvre->price, 0, ',', ' ') }} FCA</td>
                        <td><span
                                class="status-tag {{ $oeuvre->statut == 'disponible' ? 'active' : 'pending' }}">{{ $oeuvre->statut }}</span>
                        </td>
                        <td>
                            <a href="{{ route('artiste.oeuvres.edit', $oeuvre) }}"
                                style="color:var(--admin-primary);margin-right:10px;">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('artiste.oeuvres.destroy', $oeuvre) }}" method="POST" style="display:inline;"
                                onsubmit="return confirm('supprimer cette oeuvre ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:none;border:none;cursor:pointer;color:#ef4444;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:50px;color:#999;">
                            <i class="fa-solid fa-palette"
                                style="font-size:2rem;margin-bottom:10px;display:block;opacity:0.3;"></i>
                            <p>Vous n'avez pas encore publié d'œuvres.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Publication --}}

    <div id="uploadModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeUploadModal()">&times;</span>
            <h3>Publier une nouvelle œuvre</h3>
            <form action="{{ route('artiste.oeuvres.store') }}" method="POST" enctype="multipart/form-data"
                class="upload-form">
                @csrf

                @if ($errors->any())

                    <div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:8px;margin-bottom:15px;">
                        {{ $errors->first() }}
                    </div>

                @endif

                <div class="drop-zone" id="dropZone" onclick="document.getElementById('fileInput').click()">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <p>Glissez votre image ici (JPG, PNG, max 5Mo)</p>
                    <input type="file" name="image" id="fileInput" hidden accept="image/*" required>
                </div>
                <input type="text" name="titre" placeholder="Titre de l'œuvre" required value="{{ old('titre') }}">
                <textarea name="description" placeholder="Histoire derrière cette œuvre..." required>{{ old('description') }}
                    </textarea>
                <div class="input-row">
                    <input type="number" name="price" placeholder="Prix (FCFA) *" required min="0"
                        value="{{ old('price') }}">
                    <input type="number" name="stock" placeholder="combien en stock ?" value="{{ old('stock') }}" min="1"
                        required>
                    <select name="categorie_id" required>
                        <option value="">-- Categorie --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('categorie_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-primary">Mettre en vente</button>
            </form>
        </div>
    </div>


@endsection

@push('scripts')

    <script>
        // Réouvrir le modal si erreur de validation

        @if($errors->any())
            document.addEventListener('DOMContentLoaded', () => openUploadModal());
        @endif

        // Prévisualisation de l'image
        document.getElementById('fileInput')?.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (ev) => {
                    document.getElementById('dropZone').style.backgroundImage = `url(${ev.target.result})`;
                    document.getElementById('dropZone').style.backgroundSize = 'cover';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

@endpush
