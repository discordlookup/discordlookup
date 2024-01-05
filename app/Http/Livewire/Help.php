<?php

namespace App\Http\Livewire;

use F9Web\Meta\Meta;
use Livewire\Component;

class Help extends Component
{
    public function mount()
    {
        Meta::set('title', __('Help'))
            ->set('og:title', __('Help'))
            ->set('description', __('Get more out of Discord with Discord Lookup! Snowflake Decoder, Guild List with Stats, Invite Info and more...'))
            ->set('og:description', __('Get more out of Discord with Discord Lookup! Snowflake Decoder, Guild List with Stats, Invite Info and more...'))
            ->set('keywords', 'help, faq, frequently asked questions, questions, support, ' . getDefaultKeywords());
    }

    public function render()
    {
        return view('help')->extends('layouts.app');
    }
}
