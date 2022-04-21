<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GuildShardCalculator extends Component
{

    public $guildId = '';
    public $totalShards = '';

    public function mount()
    {

    }

    public function render()
    {
        return view('guild-shard-calculator')->extends('layouts.app');
    }
}
