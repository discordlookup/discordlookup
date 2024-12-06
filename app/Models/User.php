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
        'global_name',
        'discriminator',
        'avatar',
        'locale',
        'flags',
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
     * Set the user role connection metadata
     *
     * @return bool
     */
    public function updateRoleConnectionsMetadata()
    {
        $countOwner = 0;
        $countAdministrator = 0;
        $countModerator = 0;
        $countAdministratorVerified = 0;
        $countAdministratorPartnered = 0;

        if($this->guild_list != null)
        {
            foreach ($this->guild_list as $guild)
            {
                if(array_key_exists('owner', $guild) && $guild['owner']) $countOwner++;

                if(array_key_exists('permissions', $guild)) {
                    if (hasAdministrator($guild['permissions'])) {
                        $countAdministrator++;

                        if(array_key_exists('features', $guild))
                        {
                            if (in_array('VERIFIED', $guild['features'])) $countAdministratorVerified++;
                            if (in_array('PARTNERED', $guild['features'])) $countAdministratorPartnered++;
                        }
                    }
                    if (hasModerator($guild['permissions'])) $countModerator++;
                }
            }

            $countAdministrator -= $countOwner;
            $countModerator = $countModerator - $countOwner - $countAdministrator;
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . decrypt($this->discord_token),
        ])->put(
            config('discord.api_url') . '/users/@me/applications/' . config('discord.client_id') . '/role-connection',
            [
                'platform_name' => 'Discord Guild Stats',
                'metadata' => [
                    'guilds_owner' => $countOwner,
                    'guilds_admin' => $countAdministrator,
                    'guilds_mod' => $countModerator,
                    'guilds_admin_verified' => $countAdministratorVerified,
                    'guilds_admin_partnered' => $countAdministratorPartnered,
                ]
            ]
        );

        return $response->ok();
    }

    /**
     * Get the user display name
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return $this->global_name ?? $this->username;
    }

    /**
     * Get the full user username
     *
     * @return string
     */
    public function getFullUsernameAttribute()
    {
        return ($this->discriminator == '0') ? $this->username : $this->username . '#' . $this->discriminator;
    }

    /**
     * The full avatar url
     *
     * @return string
     */
    public function getAvatarUrlAttribute(){
        return $this->avatar ? getUserAvatarUrl($this->discord_id, $this->avatar) : getDefaultUserAvatarUrl($this->discord_id);
    }

    /**
     * The user guild list
     *
     * @return string
     */
    public function getGuildListAttribute()
    {
        if(session()->exists('guildsJson'))
            return session()->get('guildsJson');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . decrypt($this->discord_token),
        ])->get(config('discord.api_url') . '/users/@me/guilds?with_counts=true');

        if($response->ok())
            session()->put('guildsJson', $response->json());

        return $response->json();
    }
}
