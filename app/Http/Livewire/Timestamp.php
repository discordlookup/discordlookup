<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Timestamp extends Component
{
    public $timestamp = 0;
    public $snowflake;
    public $date = '';
    public $time = '';
    public $timezone;

    protected $listeners = ['changeTimezone'];

    public function updatedTimestamp()
    {
        $this->resetExcept('timestamp', 'timezone');
        $this->updateToDateTime();
    }

    public function updatedSnowflake()
    {
        if(invalidateSnowflake($this->snowflake)) return;

        $this->resetExcept('timestamp', 'snowflake', 'timezone');
        $this->timestamp = round(getTimestamp($this->snowflake) / 1000);
        $this->updateToDateTime();
    }

    public function updatedDate()
    {
        $this->updateFromDateTime();
    }

    public function updatedTime()
    {
        $this->updateFromDateTime();
    }

    public function updatedTimezone()
    {
        $this->updateFromDateTime();
    }

    public function updateFromDateTime()
    {
        $this->resetExcept('timestamp', 'date', 'time', 'timezone');
        if($this->date || $this->time)
        {
            $tz = date_default_timezone_get();
            if($this->timezone)
                date_default_timezone_set($this->timezone);

            $this->timestamp = strtotime($this->date . " " . $this->time);

            if($this->timezone)
                date_default_timezone_set($tz);
        }
    }

    public function updateToDateTime()
    {
        if(!$this->timestamp) return;
        if(!validateInt($this->timestamp)) return;

        $tz = date_default_timezone_get();
        if($this->timezone)
            date_default_timezone_set($this->timezone);

        $this->date = date('Y-m-d', $this->timestamp);
        $this->time = date('H:i', $this->timestamp);

        if($this->timezone)
            date_default_timezone_set($tz);
    }

    public function changeTimezone($tz)
    {
        $this->timezone = $tz;
    }

    public function mount()
    {
        if($this->timestamp == 0)
            $this->timestamp = time();
    }

    public function render()
    {
        $this->dispatchBrowserEvent('updateTimestamp', ['timestamp' => $this->timestamp]);
        $this->updateToDateTime();

        return view('timestamp')->extends('layouts.app');
    }
}
