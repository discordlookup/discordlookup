<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GuildlistItem extends Component
{
    public $guild;

    public function render()
    {
        return view('livewire.guildlist-item');
    }
}
