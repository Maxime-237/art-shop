<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'bio',
        'avatar'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    public function oeuvres() {
        return $this->hasMany(Oeuvre::class);
    }
    public function commandes() {
        return $this->hasMany(Commande::class);
    }

    public function review() {
        return $this->hasMany(Review::class);
    }

    public function isAdmin(): bool {
        return $this->role === 'admin';
    }

    public function isArtiste(): bool {
        return $this->role === 'artiste';
    }

    public function isClient(): bool {
        return $this->role === 'client';
    }

}
