<?php

namespace App\Http\Livewire;

use Livewire\Component;

class WebhookInvalidator extends Component
{
    public function render()
    {
        return view('webhook-invalidator')->extends('layouts.app');
    }
}
