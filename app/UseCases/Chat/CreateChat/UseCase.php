<?php

namespace App\UseCases\Chat\CreateChat;

use App\Models\Chat;
use Exception;

class UseCase
{
    public function execute(Input $input): Chat
    {
        if ($input->is_group && is_null($input->name)) {
            throw new Exception("It is necessary to enter a name for a group chat.");
        }

        $chat = new Chat();
        $chat->is_group = $input->is_group;
        $chat->name = $input->name;
        $chat->photo = $input->photo;

        if (!$chat->save()) {
            throw new Exception("Unable to create a chat.");
        }

        return $chat;
    }
}
