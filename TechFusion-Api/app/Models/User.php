<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <--- adiciona isso!

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // <--- adiciona HasApiTokens aqui

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // <--- adiciona isso pra permitir preencher via create()
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
            'is_admin' => 'boolean', // <--- pra o campo ser interpretado como true/false
        ];
    }
}