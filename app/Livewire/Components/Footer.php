<?php

namespace App\Livewire\Components;

use App\Events\ChatUpdated;
use App\Models\Chat;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Footer extends Component
{
    public Chat $chat;

    #[Rule(['required', 'string', 'max:255'])]
    public $body;

    public function submit()
    {
        $this->validate();

        $message = $this->chat->messages()->create([
            'user_id' => auth()->id(),
            'body' => $this->body,
            'type' => 1,
        ]);

        $this->reset('body');

        broadcast(new ChatUpdated($this->chat))->toOthers();

        $this->dispatch('message-created', id: $message->uuid);
    }

    public function render()
    {
        return view('livewire.components.footer');
    }
}
