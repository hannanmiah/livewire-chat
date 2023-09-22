<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Home extends Component
{
    public $key = '';

    public function refreshKey()
    {
        $this->key = now()->toString();
    }

    public function render()
    {
        return view('livewire.pages.home');
    }
}
