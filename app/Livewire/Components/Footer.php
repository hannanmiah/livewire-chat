<?php

namespace App\Livewire\Components;

use App\Events\ChatUpdated;
use App\Models\Chat;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Notification;
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

        Notification::send($this->chat->chat_users->pluck('user'), new UserNotification($message));

        broadcast(new ChatUpdated($this->chat))->toOthers();

        $this->dispatch('message-created', uuid: $message->uuid);
    }

    public function render()
    {
        return view('livewire.components.footer');
    }
}
