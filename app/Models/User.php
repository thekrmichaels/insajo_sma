<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Laravel Ban
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;

use Spatie\Permission\Traits\HasRoles; // Asocia el modelo Usuario de Laravel con el modelo Rol de Spatie.

class User extends Authenticatable /*Derecha: Laravel Ban. */ implements BannableContract
{
    use HasApiTokens, HasFactory, Notifiable;

    use HasRoles; // Asocia el modelo Usuario de Laravel con el modelo Rol de Spatie.

    use Bannable; // Laravel Ban

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'banned_at',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
