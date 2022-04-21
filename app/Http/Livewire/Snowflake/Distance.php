<?php

namespace App\Http\Livewire\Snowflake;

use Livewire\Component;

class Distance extends Component
{

    public $snowflake1 = '';
    public $snowflake2 = '';

    public function mount()
    {

    }

    public function render()
    {
        return view('snowflake.distance')->extends('layouts.app');
    }
}
