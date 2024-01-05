<?php

namespace App\Http\Livewire\Lookup;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use F9Web\Meta\Meta;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class User extends Component
{
    use WithRateLimiting;

    public $fetched = false;
    public $snowflake;
    public $userData;
    public $errorMessage;

    public $rateLimitHit = false;
    public $rateLimitAvailableIn = 0;

    protected $listeners = ['fetchUser'];

    public function fetchUser()
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

        $this->fetched = true;
        $this->userData = getUser($this->snowflake);
    }

    public function mount()
    {
        if($this->snowflake)
            $this->fetchUser();

        Meta::set('title', __('User Lookup'))
            ->set('og:title', __('User Lookup'))
            ->set('description', __('Get detailed information about Discord users with creation date, profile picture, banner and badges.'))
            ->set('og:description', __('Get detailed information about Discord users with creation date, profile picture, banner and badges.'))
            ->set('keywords', 'user, member, user lookup, member info, user info, user search, member search, username, discord user, ' . getDefaultKeywords());
    }

    public function render()
    {
        return view('lookup.user')->extends('layouts.app');
    }
}
