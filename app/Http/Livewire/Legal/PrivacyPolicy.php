<?php

namespace App\Http\Livewire\Legal;

use F9Web\Meta\Meta;
use Livewire\Component;

class PrivacyPolicy extends Component
{
    public function mount()
    {
        Meta::set('title', __('Privacy Policy'))
            ->set('og:title', __('Privacy Policy'))
            ->set('description', __('Privacy Policy of DiscordLookup.com'))
            ->set('og:description', __('Privacy Policy of DiscordLookup.com'))
            ->set('keywords', 'privacy, policy, legal, ' . getDefaultKeywords())
            ->set('robots', 'noindex, nofollow');
    }

    public function render()
    {
        return view('legal.privacy-policy')->extends('layouts.app');
    }
}
