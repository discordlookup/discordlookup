<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(Request $request, $roleConnections = false)
    {
        $request->session()->put('loginRedirect', url()->previous());

        $scopes = ['identify', 'guilds'];

        if ($request->session()->exists('joinDiscordAfterLogin') && $request->session()->get('joinDiscordAfterLogin'))
            $scopes[] = 'guilds.join';

        if ($roleConnections)
            $scopes[] = 'role_connections.write';

        return Socialite::driver('discord')
            ->setScopes($scopes)
            ->with([
                //'prompt' => 'none',
            ])
            ->redirect();
    }

    public function loginWithRoleConnections(Request $request)
    {
        return $this->login($request, true);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(url()->previous());
    }

    public function callback(Request $request)
    {
        try {
            $discordUser = Socialite::driver('discord')->user();
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect(RouteServiceProvider::HOME);
        }

        if($request->session()->exists('joinDiscordAfterLogin')) {
            Http::withHeaders([
                'Authorization' => 'Bot ' . env('DISCORD_BOT_TOKEN'),
            ])->put(
                env('DISCORD_API_URL') . '/guilds/' . env('DISCORD_GUILD_ID') . '/members/' . $discordUser->user['id'],
                [
                    'access_token' => $discordUser->token,
                ]
            );
            $request->session()->remove('joinDiscordAfterLogin');
        }

        $userData = [
            'username' => $discordUser->user['username'],
            'global_name' => $discordUser->user['global_name'],
            'discriminator' => $discordUser->user['discriminator'],
            'avatar' => $discordUser->user['avatar'],
            'locale' => $discordUser->user['locale'],
            'flags' => $discordUser->user['flags'],
            'discord_token' => encrypt($discordUser->token),
        ];

        $user = User::firstOrCreate(
            [
                'discord_id' => $discordUser->user['id'],
            ],
            $userData
        );

        if (!$user->wasRecentlyCreated)
            $user->update($userData);

        $user->updateRoleConnectionsMetadata();

        Auth::login($user, true);

        return redirect($request->session()->get('loginRedirect'));
    }
}
