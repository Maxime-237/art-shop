<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [
        'user_id',
        'quantite',
        'total_price',
        'status'
    ];

    public function User() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(CommandeItem::class);
    }
}
