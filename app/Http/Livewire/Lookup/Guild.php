<?php

namespace App\Http\Livewire\Lookup;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use F9Web\Meta\Meta;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class Guild extends Component
{
    use WithRateLimiting;

    public $snowflake;
    public $snowflakeDate;
    public $snowflakeTimestamp;
    public $guildData = [];
    public $guildClanData;
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

        if (App::environment('production')) {
            try {
                $this->rateLimit(auth()->check() ? 10 : 3, auth()->check() ? 2 * 60 : 3 * 60);
            } catch (TooManyRequestsException $exception) {
                $this->rateLimitHit = true;
                $this->rateLimitAvailableIn = $exception->secondsUntilAvailable;
                return;
            }
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

        if ($this->guildData && is_array($this->guildData) && isset($this->guildData['features']) && is_array($this->guildData['features']) && (in_array('clan', $this->guildData['features']) || in_array('CLAN', $this->guildData['features'])))
            $this->guildClanData = getDiscoveryClan($this->snowflake);

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

        Meta::set('title', __('Guild Lookup'))
            ->set('og:title', __('Guild Lookup'))
            ->set('description', __('Get detailed information about Discord guilds with creation date, Invite/Vanity URL, features and emojis.'))
            ->set('og:description', __('Get detailed information about Discord guilds with creation date, Invite/Vanity URL, features and emojis.'))
            ->set('keywords', 'guild, server, guild lookup, guild search, guild info, ' . getDefaultKeywords());
    }

    public function render()
    {
        return view('lookup.guild')->extends('layouts.app');
    }
}
