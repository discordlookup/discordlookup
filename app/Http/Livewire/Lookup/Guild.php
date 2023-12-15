<?php

namespace App\Http\Livewire\Lookup;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Livewire\Component;

class Guild extends Component
{
    use WithRateLimiting;

    public $snowflake;
    public $snowflakeDate;
    public $snowflakeTimestamp;
    public $guildData = [];
    public $errorMessage;

    public $rateLimitHit = false;
    public $rateLimitAvailableIn = 0;

    protected $listeners = ['fetchGuild', 'processInviteJson'];

    public function fetchGuild()
    {
        $this->resetExcept(['snowflake']);

        if($this->snowflake == null) return;

        $this->errorMessage = invalidateSnowflake($this->snowflake);
        if($this->errorMessage) return;

        try {
            $this->rateLimit(auth()->check() ? 10 : 3, auth()->check() ? 2*60 : 3*60);
        }
        catch (TooManyRequestsException $exception)
        {
            $this->rateLimitHit = true;
            $this->rateLimitAvailableIn = $exception->secondsUntilAvailable;
            return;
        }

        $this->snowflakeTimestamp = getTimestamp($this->snowflake);
        $this->snowflakeDate = date('Y-m-d G:i:s \(T\)', $this->snowflakeTimestamp / 1000);

        $guildWidget = getGuildWidget($this->snowflake);
        $guildPreview = getGuildPreview($this->snowflake);
        if($guildWidget && $guildWidget['instantInviteUrlCode'] != null)
            $this->dispatchBrowserEvent('getInviteInfo', ['inviteCode' => $guildWidget['instantInviteUrlCode']]);

        if($guildWidget)
            $this->guildData = $guildWidget;

        if($guildPreview)
        {
            foreach ($guildPreview as $key => $value)
            {
                if(array_key_exists($key, $this->guildData) && !empty($this->guildData[$key]))
                    continue;

                $this->guildData[$key] = $value;
            }
        }

        $this->dispatchBrowserEvent('updateRelative', ['timestamp' => $this->snowflakeTimestamp]);
    }

    public function processInviteJson($json)
    {
        $inviteInfo = parseInviteJson($json);
        if($inviteInfo != null)
        {
            foreach (array_merge($inviteInfo['guild']) as $key => $value)
            {
                if(array_key_exists($key, $this->guildData) && !empty($this->guildData[$key]))
                    continue;

                $this->guildData[$key] = $value;
            }
        }
    }

    public function mount()
    {
        if($this->snowflake)
            $this->fetchGuild();
    }

    public function render()
    {
        return view('lookup.guild')->extends('layouts.app');
    }
}
