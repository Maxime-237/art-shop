<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oeuvre extends Model
{
    protected $fillable = [
        'user_id',
        'categorie_id',
        'titre',
        'slug',
        'description',
        'price',
        'stock',
        'statut',
        'image',
        'vues'
    ];

    public function artiste() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function categorie() {
        return $this->belongsTo(Categorie::class);
    }

    public function images() {
        return $this->hasMany(OeuvreImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function Commande() {
        return $this->hasMany(Commande::class);
    }

    public function CommandeItem() {
        return $this->hasMany(CommandeItem::class);
    }

    // Accesseur note moyenne
    public function getNotemoyenne(): float
    {
        return $this->reviews()->avg('note') ?? 0;
    }

    public function getImageUrlAttribute() : string {
        //si l'image est une url on la retourne telle quelle

        if(str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        //si c'est un fichier uploadé on ajoute storage
        return asset('storage/' . $this->image);
    }
}
