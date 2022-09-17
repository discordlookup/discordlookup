<?php

namespace App\Http\Livewire\Lookup;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Livewire\Component;

class Application extends Component
{
    use WithRateLimiting;

    public $snowflake;
    public $snowflakeDate;
    public $snowflakeTimestamp;
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

        $this->snowflakeTimestamp = getTimestamp($this->snowflake);
        $this->snowflakeDate = date('Y-m-d G:i:s \(T\)', $this->snowflakeTimestamp / 1000);

        $this->applicationData = getApplicationRpc($this->snowflake);

        $this->dispatchBrowserEvent('updateRelative', ['timestamp' => $this->snowflakeTimestamp]);
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
