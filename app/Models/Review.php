<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'oeuvre_id',
        'note',
        'commentaire'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function oeuvre() {
        return $this->belongsTo(Oeuvre::class);
    }
}
