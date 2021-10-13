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
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The user displayname (username + discriminator)
     *
     * @return string
     */
    public function getDisplayNameAttribute(){
        return $this->username . '#' . $this->discriminator;
    }

    /**
     * The full avatar url
     *
     * @return string
     */
    public function getAvatarUrlAttribute(){
        return 'https://cdn.discordapp.com/avatars/' . $this->discord_id . '/' . $this->avatar;
    }
}
