<?php

namespace App\Http\Livewire\Snowflake;

use Livewire\Component;

class Index extends Component
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
    {}

    public function render()
    {
        $this->processSnowflake();
        return view('snowflake.index')->extends('layouts.app');
    }
}
