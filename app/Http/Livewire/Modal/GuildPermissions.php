<?php

namespace App\Http\Livewire\Modal;

use Livewire\Component;

class GuildPermissions extends Component
{
    public $guildName = '';
    public $permissionsList = [];

    protected $listeners = ['update'];

    public function update($guildName, $permissions)
    {
        $this->reset();

        $this->guildName = urldecode($guildName);
        $this->permissionsList = getPermissionsNames($permissions);
        sort($this->permissionsList);
    }

    public function render()
    {
        return view('modal.guild-permissions');
    }
}
