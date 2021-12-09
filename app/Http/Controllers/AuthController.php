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
    public function login(Request $request)
    {
        $request->session()->put('loginRedirect', url()->previous());

        return Socialite::driver('discord')
            ->setScopes(['identify', 'guilds'])
            ->with([
                'prompt' => 'none',
            ])
            ->redirect();
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

        $response = Http::withHeaders([
            'Authorization' => "Bearer " . $discordUser->token
        ])->get(env('DISCORD_API_URL') . '/users/@me/guilds');

        $request->session()->put('guildsJson', $response->json());

        $userData = [
            'username' => $discordUser->user['username'],
            'discriminator' => $discordUser->user['discriminator'],
            'avatar' => str_replace('https://cdn.discordapp.com/avatars/' . $discordUser->user['id'] . '/', '', $discordUser->avatar),
            'locale' => $discordUser->user['locale'],
        ];

        $user = User::firstOrCreate(
            [
                'discord_id' => $discordUser->user['id'],
            ],
            $userData
        );

        if (!$user->wasRecentlyCreated) {
            $user->update($userData);
            $request->session()->put('github-upsell', true);
        }

        Auth::login($user);

        return redirect($request->session()->get('loginRedirect'));
    }
}
