<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GuildShardCalculator extends Component
{
    public $guildId;
    public $totalShards;
    public $shardId;
    public $errorMessage;

    public function calculateShardId()
    {
        $this->resetExcept(['guildId', 'totalShards']);

        if($this->guildId == null || $this->totalShards == null) return;

        $this->errorMessage = invalidateSnowflake($this->guildId);
        if (!validateInt($this->totalShards))
        {
            $this->errorMessage = __('Total Shards must be a valid number!');
        }

        if($this->errorMessage) return;

        $this->shardId = getShardId($this->guildId, $this->totalShards);
    }

    public function mount()
    {}

    public function render()
    {
        $this->calculateShardId();
        return view('guild-shard-calculator')->extends('layouts.app');
    }
}
