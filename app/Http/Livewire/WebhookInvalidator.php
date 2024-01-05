<?php

namespace App\Http\Livewire;

use F9Web\Meta\Meta;
use Livewire\Component;

class WebhookInvalidator extends Component
{
    public function mount()
    {
        Meta::set('title', __('Discord Webhook Invalidator'))
            ->set('og:title', __('Discord Webhook Invalidator'))
            ->set('description', __('Immediately delete a Discord webhook to eliminate evil webhooks.'))
            ->set('og:description', __('Immediately delete a Discord webhook to eliminate evil webhooks.'))
            ->set('keywords', 'webhook, invalidator, delete, delete webhook, invalidate webhook, ' . getDefaultKeywords());
    }

    public function render()
    {
        return view('webhook-invalidator')->extends('layouts.app');
    }
}
