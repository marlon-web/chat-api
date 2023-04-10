<?php

namespace App\UseCases\Message\CreateMessage;


use App\Models\Chat;
use App\Models\User;
use App\Shared\Enums\MessageType;

class Input
{
    public function __construct(
        public MessageType $type,
        public string $content,
        public User $author,
        public ?Chat $chat = null,
        public ?User $recipient = null
    ){}
}
