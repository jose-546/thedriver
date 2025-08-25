<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username', // Ajout du champ username
        'password',
        'phone',
        'address',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Vérifie si l'utilisateur est administrateur
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur est un client
     */
    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    /**
     * Relation avec les réservations
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}