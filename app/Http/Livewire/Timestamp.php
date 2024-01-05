<?php

namespace App\Http\Livewire;

use DateTimeZone;
use F9Web\Meta\Meta;
use Livewire\Component;

class Timestamp extends Component
{
    public $timestamp = 0;
    public $timestampSlug;
	public $timestampChanged = false;
    public $snowflake;
    public $date = '';
    public $time = '';
    public $timezone;

    protected $listeners = ['changeTimezone'];

	protected function updateSlug()
	{
		if ($this->timestampChanged) {
			$this->timestampSlug = $this->timestamp;
		}
	}

	public function updated(){
		$this->timestampChanged = true;
	}

    public function updatedTimestamp()
    {
        $this->resetExcept('timestamp', 'timestampSlug', 'timestampChanged', 'timezone');

        $this->updateToDateTime();
    }

    public function updatedSnowflake()
    {
        if(invalidateSnowflake($this->snowflake)) return;

        $this->resetExcept('timestamp', 'timestampSlug', 'timestampChanged', 'snowflake', 'timezone');
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
        $this->resetExcept('timestamp', 'timestampSlug', 'timestampChanged', 'date', 'time', 'timezone');
        if($this->date || $this->time)
        {
            $tz = date_default_timezone_get();
            if($this->timezone) {
                if(in_array($this->timezone, DateTimeZone::listIdentifiers())) {
                    date_default_timezone_set($this->timezone);
                }
            }

            $this->timestamp = strtotime($this->date . ' ' . $this->time);
			$this->updateSlug();

            if($this->timezone)
                date_default_timezone_set($tz);
        }
    }

    public function updateToDateTime()
    {
        if(!$this->timestamp) return;
        if(!validateInt($this->timestamp)) return;

		$this->updateSlug();

        $tz = date_default_timezone_get();
        if($this->timezone) {
            if(in_array($this->timezone, DateTimeZone::listIdentifiers())) {
                date_default_timezone_set($this->timezone);
            }
        }

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
        if ($this->timestampSlug == 0) {
			$this->timestamp = time();
		} else {
			$this->timestamp = $this->timestampSlug;
			$this->timestampChanged = true;
		}

        Meta::set('title', __('Timestamp Styles'))
            ->set('og:title', __('Timestamp Styles'))
            ->set('description', __('Generate Discord timestamp styles based on a date, time, snowflake or timestamp.'))
            ->set('og:description', __('Generate Discord timestamp styles based on a date, time, snowflake or timestamp.'))
            ->set('keywords', 'timestamp, time, date, styles, format, formatting, snowflake, ' . getDefaultKeywords());
    }

    public function render()
    {
        $this->dispatchBrowserEvent('updateTimestamp', ['timestamp' => $this->timestamp]);
        $this->updateToDateTime();

        return view('timestamp')->extends('layouts.app');
    }
}
