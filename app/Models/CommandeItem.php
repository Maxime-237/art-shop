<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandeItem extends Model
{
    protected $fillable = [
        'commande_id',
        'oeuvre_id',
        'quantite',
        'price_unit'
    ];

    public function Commande() {
        return $this->belongsTo(Commande::class);
    }

    public function Oeuvre() {
        return $this->belongsTo(Oeuvre::class);
    }
}
