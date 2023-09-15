<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class TestComponent extends Component
{
    #[On('form-submitted')]
    #[On('quote-submitted')]
    public function render()
    {
        return view('livewire.components.test-component');
    }
}
