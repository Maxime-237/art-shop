<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oeuvre extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'titre',
        'slug',
        'description',
        'price',
        'stock',
        'statut',
        'image'
    ];

    public function Artiste() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function Category() {
        return $this->belongsTo(Categorie::class);
    }

    // public function images() {
    //     return $this->hasMany(Oeuvre_image::class);
    // }

    public function Commande() {
        return $this->hasMany(Commande::class);
    }

    public function CommandeItem() {
        return $this->hasMany(CommandeItem::class);
    }
}
