<?php

namespace App\Http\Livewire\Legal;

use F9Web\Meta\Meta;
use Livewire\Component;

class LegalNotice extends Component
{
    public function mount()
    {
        Meta::set('title', __('Legal Notice'))
            ->set('og:title', __('Legal Notice'))
            ->set('description', __('Legal Provider Identification of DiscordLookup.com'))
            ->set('og:description', __('Legal Provider Identification of DiscordLookup.com'))
            ->set('keywords', 'legal notice, ' . getDefaultKeywords())
            ->set('robots', 'noindex, nofollow');
    }

    public function render()
    {
        return view('legal.legal-notice')->extends('layouts.app');
    }
}
