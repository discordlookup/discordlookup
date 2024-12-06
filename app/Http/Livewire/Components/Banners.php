<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class Banners extends Component
{
    public function render()
    {
        $banners = [
            [
                'id' => '2022-09-08_discord-server',
                'text' => '<i class="fab fa-discord"></i> We now have a Discord server!',
                'buttonText' => 'Join Discord',
                'buttonUrl' => config('app.discord_url'),
                'buttonTarget' => '_blank',
                'requiredAuth' => false,
            ],
            [
                'id' => '2022-09-08_github-star',
                'text' => '<i class="fas fa-star"></i> Do you like DiscordLookup? Star us on GitHub &#128154;',
                'buttonText' => 'GitHub',
                'buttonUrl' => config('app.github_url'),
                'buttonTarget' => '_blank',
                'requiredAuth' => true,
            ],
        ];

        return view('components.banners', compact('banners'))->extends('layouts.app');
    }
}
