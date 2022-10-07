<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InviteResolver extends Component
{
    public $inviteCode;
    public $inviteCodeDisplay;
    public $eventId;
    public $inviteData = [];

    public $loading = false;

    protected $listeners = ['fetchInvite', 'processInviteJson'];

    public function fetchInvite()
    {
        $this->resetExcept(['inviteCode', 'inviteCodeDisplay', 'eventId']);

        if(str_contains($this->inviteCode, '?event='))
        {
            $url = explode('?event=', $this->inviteCode);
            $this->eventId = end($url);
            $this->inviteCode = $url[0];
        }
        $url = explode('/', $this->inviteCode);
        $this->inviteCode = end($url);

        if($this->inviteCode)
        {
            $this->loading = true;
            $this->dispatchBrowserEvent('fetchInvite', [
                'inviteCode' => $this->inviteCode,
                'eventId' => $this->eventId,
            ]);
        }
    }

    public function processInviteJson($json)
    {
        $this->resetExcept(['inviteCode', 'inviteCodeDisplay', 'eventId']);

        if($this->inviteCode)
        {
            $this->inviteData = parseInviteJson($json);
            if($this->inviteData)
            {
                $guildId = $this->inviteData['guild']['id'];
                if($guildId)
                {
                    $guildWidget = getGuildWidget($guildId);
                    $guildPreview = getGuildPreview($guildId);

                    if($guildWidget)
                    {
                        foreach ($guildWidget as $key => $value)
                        {
                            if(array_key_exists($key, $this->inviteData['guild']) && !empty($this->inviteData['guild'][$key]))
                                continue;

                            $this->inviteData['guild'][$key] = $value;
                        }
                    }

                    if($guildPreview)
                    {
                        foreach ($guildPreview as $key => $value)
                        {
                            if(array_key_exists($key, $this->inviteData['guild']) && !empty($this->inviteData['guild'][$key]))
                                continue;

                            $this->inviteData['guild'][$key] = $value;
                        }
                    }
                }
            }
        }
    }

    public function mount()
    {
        if($this->inviteCode && $this->inviteCode != '-') { 
			$this->loading = true;
		}

		$this->inviteCodeDisplay = $this->inviteCode;

		if ($this->inviteCode == '-') {
			$this->inviteCodeDisplay = '';
		}
    }

	public function updated($name, $value)
	{
		if ($name == 'inviteCodeDisplay') {
			$this->inviteCode = $value;
		}

		if($this->inviteCode == '' && $this->eventId != '') {
			$this->inviteCode = '-';
		}

		if($this->inviteCode == '-' && $this->eventId == '') {
			$this->inviteCode = '';
		}

		if ($this->inviteCode == '-') {
			$this->inviteCodeDisplay = '';
		}
	}

    public function render()
    {
        return view('invite-resolver')->extends('layouts.app');
    }
}
