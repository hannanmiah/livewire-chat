<?php

namespace App\Livewire\Pages;

use App\Models\Chat as ChatModel;
use Livewire\Attributes\On;
use Livewire\Component;

class Chat extends Component
{
    public ChatModel $chat;

    #[On('message-created')]
    public function refresh()
    {
        $this->chat->refresh();
    }

    public function render()
    {
        return view('livewire.pages.chat');
    }
}
