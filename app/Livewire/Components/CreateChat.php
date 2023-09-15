<?php

namespace App\Livewire\Components;

use App\Models\Chat;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateChat extends Component
{
    public $contacts;

    #[Rule(['required', 'string', 'max:255'])]
    public $type;

    #[Rule(['required_if:type,group', 'nullable', 'unique:chats', 'string', 'max:255'])]
    public $name;

    #[Rule(['required', 'array', 'min:1', 'max:100'])]
    public $selectedContacts = [];

    public function mount()
    {
        $this->contacts = User::query()->where('id', '!=', auth()->id())->get();
    }

    #[On('form-updated')]
    public function setForm($type, $selectedContacts)
    {
        $this->type = $type;
        $this->selectedContacts = $selectedContacts;

        if ($type === 'private' && count($selectedContacts) > 1) {
            $this->type = 'group';
        }

        $this->contacts = User::query()->find($selectedContacts);
    }

    public function submit()
    {
        $this->validate();

        if ($this->type === 'private') {
            $chat = Chat::query()->whereHas('chat_users', function ($q) {
                $q->where('user_id', auth()->id());
            })->whereHas('chat_users', function ($q) {
                $q->whereIn('user_id', $this->selectedContacts);
            })->where('type', 'private')->first();

            if ($chat) {
                $this->dispatch('chat-created');
                $this->reset(['type', 'selectedContacts', 'name']);
                return;
            }
        }

        $chat = Chat::query()->create([
            'name' => $this->name,
            'type' => $this->type,
        ]);

        $chat->chat_users()->createMany([
            [
                'user_id' => auth()->id(),
                'status' => 'active',
                'role' => 'admin',
            ],
            ...collect($this->selectedContacts)->map(function ($contact) {
                return [
                    'user_id' => $contact,
                    'status' => 'active',
                ];
            })->toArray(),
        ]);

        $chat->messages()->create([
            'user_id' => auth()->id(),
            'body' => 'Started this conversation...',
        ]);

        $this->reset(['type', 'selectedContacts', 'name']);
        $this->dispatch('chat-created');
    }

    public function render()
    {
        return view('livewire.components.create-chat');
    }
}
