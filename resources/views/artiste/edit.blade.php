{{--  Modifier ue oeuvre --}}

@extends('layouts.artiste')

@section('title', 'Modifier | ' . $oeuvre->titre)

@section('content')

    <header class="top-bar">
        <h2>Modifier <span>« {{ Str::limit($oeuvre->titre, 30) }} »</span></h2>
        <a href="{{ route('artiste.dashboard') }}" style="color:#64748b;text-decoration:none;font-size:0.9rem;">
            <i class="fa-solid fa-arrow-left"></i> Retour au studio
        </a>
    </header>

    <div
        style="max-width:700px;margin:30px auto;background:white;padding:40px;border-radius:15px;box-shadow:0 5px 20px rgba(0,0,0,0.06);">

        @if($errors->any())
            <div style="background:#fee2e2;color:#dc2626;padding:12px 16px;border-radius:8px;margin-bottom:20px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('artiste.oeuvres.update', $oeuvre) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Image actuelle --}}
            <div style="margin-bottom:25px;">

                <label style="font-weight:600;display:block;margin-bottom:10px;">Image actuelle</label>
                <img src="{{ $oeuvre->image }}" alt="{{ $oeuvre->titre }}"
                    style="width:100%;max-height:300px;object-fit:cover;border-radius:10px;"
                >
                <div style="margin-top:12px;">
                    <label style="font-weight:600;display:block;margin-bottom:8px;">
                        Changer l'image <span style="color:#aaa;font-size:0.85rem;">(optionnel)</span>
                    </label>
                    <input type="file" name="image" accept="image/*"
                        style="width:100%;padding:10px;border:1px dashed #e2e8f0;border-radius:8px;"
                    >
                </div>
            </div>

            {{-- Titre --}}
            <div style="margin-bottom:20px;">

                <label style="font-weight:600;display:block;margin-bottom:8px;">Titre de l'œuvre *</label>
                <input type="text" name="titre" value="{{ old('titre', $oeuvre->titre) }}" required
                    style="width:100%;padding:12px;border:1px solid #e2e8f0;border-radius:8px;font-size:0.95rem;"
                >
            </div>

            {{-- Description --}}
            <div style="margin-bottom:20px;">

                <label style="font-weight:600;display:block;margin-bottom:8px;">Description *</label>
                <textarea name="description" required rows="5"
                    style="width:100%;padding:12px;border:1px solid #e2e8f0;border-radius:8px;font-size:0.95rem;resize:vertical;">{{ old('description', $oeuvre->description) }}</textarea>
            </div>

            {{-- Prix & Catégorie --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-bottom:25px;">

                <div>
                    <label style="font-weight:600;display:block;margin-bottom:8px;">Prix (FCFA) *</label>
                    <input type="number" name="price" value="{{ old('price', $oeuvre->price) }}" min="0" required
                        style="width:100%;padding:12px;border:1px solid #e2e8f0;border-radius:8px;">
                </div>
                <div>
                    <label style="font-weight:600;display:block;margin-bottom:8px;">Catégorie *</label>
                    <select name="categorie_id" required
                        style="width:100%;padding:12px;border:1px solid #e2e8f0;border-radius:8px;"
                    >
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $oeuvre->categorie_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display:flex;gap:12px;">
                <button type="submit" class="btn-primary" style="flex:1;padding:14px;">
                    <i class="fa-solid fa-floppy-disk"></i> Enregistrer les modifications
                </button>
                <a href="{{ route('artiste.dashboard') }}"
                    style="padding:14px 20px;border:1px solid #e2e8f0;border-radius:8px;text-decoration:none;color:#64748b;text-align:center;">
                    Annuler
                </a>
            </div>
        </form>
    </div>

@endsection
