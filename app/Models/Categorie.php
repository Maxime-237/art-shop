<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];
    public function Oeuvres() {
        return $this->hasMany(Oeuvre::class);
    }
}
