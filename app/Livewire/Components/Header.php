<?php

namespace App\Livewire\Components;

use App\Models\Chat;
use Livewire\Component;

class Header extends Component
{
    public Chat $chat;

    public function render()
    {
        return view('livewire.components.header');
    }
}
