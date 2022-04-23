<?php

namespace App\Http\Livewire\Modal;

use Livewire\Component;

class GuildFeatures extends Component
{
    public $guildName = '';
    public $features = [];

    protected $listeners = ['update'];

    public function update($guildName, $features)
    {
        $this->reset();

        $this->guildName = urldecode($guildName);
        $this->features = json_decode($features);
        sort($this->features);
    }

    public function render()
    {
        return view('modal.guild-features');
    }
}
