<?php

namespace App\Http\Livewire\Snowflake;

use Livewire\Component;

class Index extends Component
{

    public $snowflake = '';

    public function mount()
    {

    }

    public function render()
    {
        return view('snowflake.index')->extends('layouts.app');
    }
}
