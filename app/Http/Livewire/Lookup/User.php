<?php

namespace App\Http\Livewire\Lookup;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
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

        try {
            $this->rateLimit(auth()->check() ? 10 : 3, auth()->check() ? 2*60 : 3*60);
        }
        catch (TooManyRequestsException $exception)
        {
            $this->rateLimitHit = true;
            $this->rateLimitAvailableIn = $exception->secondsUntilAvailable;
            return;
        }

        $this->fetched = true;
        $this->userData = getUser($this->snowflake);
    }

    public function mount()
    {
        if($this->snowflake)
            $this->fetchUser();
    }

    public function render()
    {
        return view('lookup.user')->extends('layouts.app');
    }
}
