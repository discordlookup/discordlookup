<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('home')->extends('layouts.app');
    }
}
