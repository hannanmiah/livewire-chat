<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Rule;
use Livewire\Component;

class TestModal extends Component
{
    #[Rule(['required', 'string'])]
    public $quote = '';

    public function submit()
    {
        $this->validate();
        $this->reset(['quote']);
        $this->dispatch('quote-submitted', $this->quote);
    }

    public function render()
    {
        return view('livewire.components.test-modal');
    }
}
