<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\FormTest;
use Livewire\Attributes\On;
use Livewire\Component;

class TestForm extends Component
{
    public FormTest $form;

    public function submit()
    {
        $this->form->store();
        session()->flash('message', 'Form submitted successfully!');
        $this->dispatch('form-submitted');
    }

    #[On('quote-submitted')]
    public function render()
    {
        return view('livewire.components.test-form');
    }
}
