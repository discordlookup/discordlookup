<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GuildFeaturesModal extends Component
{

    public $guildName = "";
    public $features = [];

    protected $listeners = ['update'];

    public function update($guildName, $features) {

        $this->reset();

        $this->guildName = urldecode($guildName);
        $this->features = json_decode($features);
        sort($this->features);
    }

    public function render()
    {
        return view('livewire.guild-features-modal');
    }
}
