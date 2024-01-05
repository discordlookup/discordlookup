<?php

namespace App\Http\Livewire\Legal;

use F9Web\Meta\Meta;
use Livewire\Component;

class TermsOfService extends Component
{
    public function mount()
    {
        Meta::set('title', __('Terms of Service'))
            ->set('og:title', __('Terms of Service'))
            ->set('description', __('Terms of Service of DiscordLookup.com'))
            ->set('og:description', __('Terms of Service of DiscordLookup.com'))
            ->set('keywords', 'terms, service, terms of service, terms of use, use, legal, ' . getDefaultKeywords())
            ->set('robots', 'noindex, nofollow');
    }

    public function render()
    {
        return view('legal.terms-of-service')->extends('layouts.app');
    }
}
