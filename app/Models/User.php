<?php

namespace App\Models;

// * cybercog/laravel-ban package: Makes the user model bannable.
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // * spatie/laravel-permission package: Allows users to be associated with permissions and roles.

class User extends Authenticatable implements BannableContract
{
    use Bannable, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string, mixed>
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
     * @var array<string, mixed>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, timestamp>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
