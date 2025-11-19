<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
        'role',
        'subscription_plan',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Un especialista tiene muchos niños.
     */
    public function children()
    {
        return $this->hasMany(Child::class, 'specialist_id');
    }

    /**
     * Un usuario (autor) tiene muchos posts.
     */
    public function posts()
    {
        return $this->hasMany(\App\Models\Post::class, 'user_id');
    }
}
