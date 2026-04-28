{{--  Studio artiste + modal publication --}}

@extends('layouts.artiste')

@section('title', 'Artist Studio | ARTSHOP')

@section('content')

    <header class="top-bar">
        <h2>Bienvenu, <span id="artist-name">{{ auth()->user()->name }}</span></h2>
        <div class="top-bar-actions">
            <button class="btn-upload" onclick="openUploadModal()">
                <i class="fa-solid fa-plus"></i> Publier une œuvre
            </button>

            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=e58e26&color=fff"
                alt="profile" class="avatar-sm">
        </div>
    </header>

    {{-- Stats --}}

    <section class="stats-grid">
        <div class="stat-card">
            <i class="fa-solid fa-money-bill"></i>
            <div>
                <h3>{{ number_format($stats['ventes_totales'], 0, ',', ' ') }}</h3>
                <p>Ventes totales (FCFA)</p>
            </div>
        </div>
        <div class="stat-card">
            <i class="fa-solid fa-eye"></i>
            <div>
                <h3>{{ number_format($stats['vues']) }}</h3>
                <p>Vues du profil</p>
            </div>
        </div>
        <div class="stat-card">
            <i class="fa-solid fa-users"></i>
            <div>
                <h3>{{ $stats['oeuvres'] }}</h3>
                <p>Oeuvres publiées</p>
            </div>
        </div>
    </section>

    {{-- Portfolio --}}

    <div id="dynamic-area">
        <section class="content-section">
            <div class="section-header">
                <h3>Mes Œuvres Récentes</h3>
            </div>
            <div class="portfolio-grid" >
                @forelse ($oeuvres as $oeuvre)

                    <div work-item style="position:relative;">
                        <img src="{{ $oeuvre->image }}" alt="{{ $oeuvre->titre }}">

                        <div class="work-overlay">
                            <div class="work-actions">

                                <a href="{{ route('artiste.oeuvres.edit', $oeuvre) }}"
                                    style="background:white;border:none;padding:8px 10px;border-radius:5px;cursor:pointer;text-decoration:none;color:inherit;">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <form action="{{ route('artiste.oeuvres.destroy', $oeuvre) }}" method="POST"
                                    onsubmit="return confirm('supprimer cette oeuvre ?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        style="background:white;border:none;padding:8px 10px;border-radius:5px;cursor:pointer;color:#dc3545;">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div style="padding:10px;font-size:0.9rem;">
                            <p><strong>{{ $oeuvre->titre }}</strong></p>
                            <small>{{ number_format($oeuvre->price, 0, ',', ' ') }} FCFA</small>
                            <span style="margin-left:10px;padding:2px 8px;border-radius:10px;font-size:0.75rem;
                                                background: {{ $oeuvre->statut == 'disponible' ? '#d4edda' : '#f8d7da' }};
                                                color: {{  $oeuvre->statut === 'disponible' ? '#155724' : '#721c24' }}">

                                {{ $oeuvre->statut }}
                            </span>
                        </div>
                    </div>

                @empty

                    <div style="grid-column:1/-1;text-align:center;padding:50px;color:#999;">
                        <i class="fa-solid fa-palette"
                            style="font-size: 3rem; display: block; margin-bottom: 15px; opacity: 0.3;"></i>
                        <p>Vous n'avez pas encr publier d'ouvres.</p>
                    </div>

                @endforelse
            </div>
        </section>
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
                        value="{{ old('price') }}"
                    >
                    <input type="number" name="stock" placeholder="combien en stock ?" value="{{ old('stock') }}" min="1" required>
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
