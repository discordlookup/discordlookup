<?php

namespace App\Http\Livewire;

use F9Web\Meta\Meta;
use lastguest\Murmur;
use Livewire\Component;

class Murmurhash extends Component
{
    public $text = '';
    public $mod10000 = true;

    public $murmurhash = 0;

    public function mount()
    {
        Meta::set('title', __('MurmurHash3 Calculator'))
            ->set('og:title', __('MurmurHash3 Calculator'))
            ->set('description', __('Calculate the MurmurHash3 of a string with an optional Mod 10000.'))
            ->set('og:description', __('Calculate the MurmurHash3 of a string with an optional Mod 10000.'))
            ->set('keywords', 'murmurhash, ' . getDefaultKeywords());
    }

    public function render()
    {
        $this->murmurhash = Murmur::hash3_int($this->text);
        if($this->mod10000) {
            $this->murmurhash = $this->murmurhash % 10000;
        }

        return view('murmurhash')->extends('layouts.app');
    }
}
