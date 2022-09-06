<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Http;
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
        'discord_token',
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
        if($this->avatar != null) {
            return 'https://cdn.discordapp.com/avatars/' . $this->discord_id . '/' . $this->avatar;
        }
        return 'https://cdn.discordapp.com/embed/avatars/5.png';
    }

    /**
     * The user guild list
     *
     * @return string
     */
    public function getGuildListAttribute(){

        if(session()->exists('guildsJson')) {
            return session()->get('guildsJson');
        }

        $response = Http::withHeaders([
            'Authorization' => "Bearer " . decrypt($this->discord_token)
        ])->get(env('DISCORD_API_URL') . '/users/@me/guilds');

        if($response->ok())
            session()->put('guildsJson', $response->json());

        return $response->json();
    }
}
