<?php

namespace App\Http\Livewire;

use F9Web\Meta\Meta;
use Livewire\Component;

class Home extends Component
{
    public function mount()
    {
        Meta::set('description', __('Get more out of Discord with Discord Lookup! Snowflake Decoder, Guild List with Stats, Invite Info and more...'))
            ->set('og:description', __('Get more out of Discord with Discord Lookup! Snowflake Decoder, Guild List with Stats, Invite Info and more...'))
            ->set('keywords', getDefaultKeywords());
    }

    public function render()
    {
        return view('home')->extends('layouts.app');
    }
}
