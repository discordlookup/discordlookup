<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'discord_id',
        'discord_token',
        'username',
        'discriminator',
        'avatar',
        'locale',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'discord_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    /**
     *
     * @return string
     */
    public function getDisplayNameAttribute(){
        return $this->username . '#' . $this->discriminator;
    }
}
