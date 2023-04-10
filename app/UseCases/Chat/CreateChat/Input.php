<?php

namespace App\UseCases\Chat\CreateChat;

class Input
{
    public function __construct(
        public bool $is_group,
        public ?string $name,
        public ?string $photo,
    ){}
}
