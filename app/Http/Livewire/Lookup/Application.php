<?php

namespace App\Http\Livewire\Lookup;

use Livewire\Component;

class Application extends Component
{
    public function mount()
    {}

    public function render()
    {
        return view('lookup.application')->extends('layouts.app');
    }
}
