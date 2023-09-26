<?php

namespace App\Livewire\Components;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Navigation extends Component
{
    public $selectedContacts = [];

    public string $type;

    #[Computed]
    public function contacts()
    {
        return User::query()->where('id', '!=', auth()->id())->get();
    }

    #[Computed]
    public function chats()
    {
        return Chat::query()->join('chat_users', 'chat_users.chat_id', '=', 'chats.id')
            ->leftJoin('messages', 'chats.id', '=', 'messages.chat_id')
            ->selectRaw('chats.*, MAX(messages.created_at) as last_message_date')
            ->where('chat_users.user_id', auth()->id())
            ->groupBy('chats.id')
            ->orderBy('last_message_date', 'desc')
            ->with(['messages.user'])
            ->get();
    }

    #[On('chat-created')]
    public function clearForm()
    {
        $this->reset(['type', 'selectedContacts']);
        $this->init();
    }

    #[On('message-created')]
    public function init()
    {
        unset($this->chats);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function submit()
    {
        $this->dispatch('form-updated', $this->type, $this->selectedContacts);
    }

    public function render()
    {
        return view('livewire.components.navigation');
    }
}
