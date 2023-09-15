<?php

namespace App\Broadcasting;

use App\Models\Chat;
use App\Models\User;

class ChatChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, Chat $chat): array|bool
    {
        $user->load('chat_users');
        $chat->load('chat_users');

        if ($user->chat_users->contains('chat_id', $chat->id) &&
            $chat->chat_users->contains('user_id', $user->id)) {
            return $user->only('id', 'uuid', 'name', 'email', 'avatar_url');
        }
    }
}
