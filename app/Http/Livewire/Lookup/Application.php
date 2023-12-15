<?php

namespace App\Http\Livewire\Lookup;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Livewire\Component;

class Application extends Component
{
    use WithRateLimiting;

    public $fetched = false;
    public $snowflake;
    public $applicationData = [];
    public $errorMessage;

    public $rateLimitHit = false;
    public $rateLimitAvailableIn = 0;

    protected $listeners = ['fetchApplication'];

    public function fetchApplication()
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
        $this->applicationData = getApplicationRpc($this->snowflake);
    }

    public function mount()
    {
        if($this->snowflake)
            $this->fetchApplication();
    }

    public function render()
    {
        return view('lookup.application')->extends('layouts.app');
    }
}
