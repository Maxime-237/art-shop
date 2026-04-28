<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OeuvreImage extends Model
{
    protected $fillable = [
        'oeuvre_id',
        'chemin'
    ];

    public function oeuvre() {
        return $this->belongsTo(Oeuvre::class);
    }
}
