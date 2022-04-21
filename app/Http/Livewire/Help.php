<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Help extends Component
{
    public function render()
    {
        return view('help')->extends('layouts.app');
    }
}
