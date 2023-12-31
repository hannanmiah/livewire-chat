<?php

namespace App\Broadcasting;

use App\Models\Message;
use App\Models\User;

class MessageChannel
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
    public function join(User $user, Message $message): array|bool
    {
        $message->load('chat.chat_users.user');
        return $message->chat->chat_users->contains('user_id', $user->id);
    }
}
