<?php

namespace App\UseCases\Message\CreateMessage;

use App\Events\MessageCreated;
use App\Models\Message;
use Exception;

use App\UseCases\Chat\CreateChat\UseCase as CreateChat;
use App\UseCases\Chat\CreateChat\Input as CreateChatInput;

class UseCase
{
    private CreateChat $create_chat;

    public function __construct()
    {
        $this->create_chat = new CreateChat();
    }

    public function execute(Input $input): Message
    {
        if ($input->chat == null && $input->recipient == null) {
            throw new Exception("To create a message is necessary specify a chat or a recipient.");
        }

        if (is_null($input->chat)) {
            $input->chat = $this->create_chat->execute(
                new CreateChatInput(
                    false,
                    null,
                    null
                )
            );

            $input->chat->addParticipant($input->author);
            $input->chat->addParticipant($input->recipient);
        }

        $message = new Message();
        $message->type = $input->type;
        $message->content = $input->content;
        $message->author_id = $input->author->id;
        $message->chat_id = $input->chat->id;

        if (!$message->save()) {
            throw new Exception("Unable to create a message.");
        }

        event(new MessageCreated($message));
        return $message;
    }
}
