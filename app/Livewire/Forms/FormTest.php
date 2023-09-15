<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class FormTest extends Form
{
    #[Rule(['required', 'string', 'max:255'])]
    public $name = '';
    #[Rule(['required', 'numeric', 'max:64', 'min:18'])]
    public $age = 0;
    #[Rule(['required', 'string', 'max:255'])]
    public $occupation = '';
    #[Ruel(['required', 'string', 'max:255'])]
    public $term = '';

    public function store()
    {
        $this->validate();
        $this->reset();
    }
}
