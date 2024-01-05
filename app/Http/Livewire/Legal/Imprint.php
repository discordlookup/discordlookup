<?php

namespace App\Http\Livewire\Legal;

use F9Web\Meta\Meta;
use Livewire\Component;

class Imprint extends Component
{
    public function mount()
    {
        Meta::set('title', __('Imprint'))
            ->set('og:title', __('Imprint'))
            ->set('description', __('Legal Provider Identification of DiscordLookup.com'))
            ->set('og:description', __('Legal Provider Identification of DiscordLookup.com'))
            ->set('keywords', 'imprint, legal, ' . getDefaultKeywords())
            ->set('robots', 'noindex, nofollow');
    }

    public function render()
    {
        return view('legal.imprint');
    }
}
