<?php

namespace Tests\Unit\UseCases;

use App\Models\Chat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\UseCases\Chat\CreateChat\UseCase as CreateChat;
use App\UseCases\Chat\CreateChat\Input as CreateChatInput;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_a_chat(): void
    {
        $chat = (new CreateChat())->execute(
            new CreateChatInput(
                false,
                null,
                null
            )
        );

        $this->assertInstanceOf(Chat::class, $chat);
    }
}
