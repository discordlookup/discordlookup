<?php

namespace App\Http\Livewire\Lookup;

use Livewire\Component;

class GuildTemplate extends Component
{
    public function render()
    {
        dd(getGuildTemplate('xxx'));

        return view('lookup.guild-template')->extends('layouts.app');
    }
}
