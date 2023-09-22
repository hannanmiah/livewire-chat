<?php

namespace App\Livewire\Pages;

use App\Models\Chat as ChatModel;
use Livewire\Attributes\On;
use Livewire\Component;

class Chat extends Component
{
    public ChatModel $chat;
    public $messages;

    public function mount(ChatModel $chat)
    {
        $this->chat = $chat;
        $this->refresh();
    }

    #[On('load-more')]
    #[On('message-created')]
    public function refresh($limit = 10)
    {
        $this->chat->load('chat_users.user', 'messages.user');
        $this->messages = $this->chat->messages()->limit($limit)->latest()->get()->reverse();
        $this->dispatch('refreshed');
    }

    public function render()
    {
        return view('livewire.pages.chat');
    }
}
