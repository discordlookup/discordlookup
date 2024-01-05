<?php

namespace App\Http\Livewire;

use F9Web\Meta\Meta;
use Livewire\Component;

class Snowflake extends Component
{
    public $snowflake;
    public $snowflakeDate;
    public $snowflakeTimestamp;
    public $errorMessage;

    public function processSnowflake()
    {
        $this->resetExcept(['snowflake']);

        if($this->snowflake == null) return;

        $this->errorMessage = invalidateSnowflake($this->snowflake);
        if($this->errorMessage) return;

        $this->snowflakeTimestamp = getTimestamp($this->snowflake);
        $this->snowflakeDate = date('Y-m-d G:i:s \(T\)', $this->snowflakeTimestamp / 1000);

        $this->dispatchBrowserEvent('updateRelative', ['timestamp' => $this->snowflakeTimestamp]);
    }

    public function mount()
    {
        Meta::set('title', __('Snowflake Decoder'))
            ->set('og:title', __('Snowflake Decoder'))
            ->set('description', __('Get the creation date of a Snowflake, and detailed information about Discord users, guilds and applications.'))
            ->set('og:description', __('Get the creation date of a Snowflake, and detailed information about Discord users, guilds and applications.'))
            ->set('keywords', 'snowflakes, calculate, time, date, ' . getDefaultKeywords());
    }

    public function render()
    {
        $this->processSnowflake();
        return view('snowflake')->extends('layouts.app');
    }
}
