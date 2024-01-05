<?php

namespace App\Http\Livewire;

use F9Web\Meta\Meta;
use Livewire\Component;

class SnowflakeDistance extends Component
{
    public $snowflake1;
    public $snowflake1Display;
    public $snowflake2;
    public $snowflake1Timestamp;
    public $snowflake2Timestamp;
    public $errorMessage;

    public function processSnowflake()
    {
        $this->resetExcept(['snowflake1', 'snowflake1Display', 'snowflake2']);

        if($this->snowflake1 == null || $this->snowflake1 == '-' || $this->snowflake1Display == null || $this->snowflake2 == null) return;

        $this->errorMessage = invalidateSnowflake($this->snowflake1);
        if($this->errorMessage) return;
        $this->errorMessage = invalidateSnowflake($this->snowflake2);
        if($this->errorMessage) return;

        $this->snowflake1Timestamp = getTimestamp($this->snowflake1);
        $this->snowflake2Timestamp = getTimestamp($this->snowflake2);

        $this->dispatchBrowserEvent('update', [
            'timestamp1' => $this->snowflake1Timestamp,
            'timestamp2' => $this->snowflake2Timestamp,
        ]);
    }

	public function mount()
	{
		$this->snowflake1Display = $this->snowflake1;

		if ($this->snowflake1 == '-') {
			$this->snowflake1Display = '';
		}

        Meta::set('title', __('Snowflake Distance Calculator'))
            ->set('og:title', __('Snowflake Distance Calculator'))
            ->set('description', __('Calculate the distance between two Discord Snowflakes.'))
            ->set('og:description', __('Calculate the distance between two Discord Snowflakes.'))
            ->set('keywords', 'snowflakes, two snowflakes, distance, calculate, time, date, ' . getDefaultKeywords());
	}

	public function updated($name, $value){
		if ($name == 'snowflake1Display') {
			$this->snowflake1 = $value;
		}

		if($this->snowflake1 == '' && $this->snowflake2 != '') {
			$this->snowflake1 = '-';
		}

		if($this->snowflake1 == '-' && $this->snowflake2 == '') {
			$this->snowflake1 = '';
		}

		if ($this->snowflake1 == '-') {
			$this->snowflake1Display = '';
		}
	}

    public function render()
    {
        $this->processSnowflake();
        return view('snowflake-distance')->extends('layouts.app');
    }
}
