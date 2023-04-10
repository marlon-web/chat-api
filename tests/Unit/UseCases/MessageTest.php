<?php

namespace Tests\Unit\UseCases;

use App\Events\MessageCreated;
use App\Models\Message;
use App\Models\User;
use App\Shared\Enums\MessageType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

use App\UseCases\Message\CreateMessage\UseCase as CreateMessage;
use App\UseCases\Message\CreateMessage\Input as CreateMessageInput;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cannot_create_a_message_without_specify_a_chat_or_a_recipient()
    {
        $sender = User::factory()->create();

        $this->expectExceptionMessage("To create a message is necessary specify a chat or a recipient.");
        (new CreateMessage())->execute(
            new CreateMessageInput(
                MessageType::TEXT,
                'hello',
                $sender
            )
        );
    }

    /** @test */
    public function can_create_a_message()
    {
        $sender = User::factory()->create();
        $recipient = User::factory()->create();

        $message = (new CreateMessage())->execute(
            new CreateMessageInput(
                MessageType::TEXT,
                'hello',
                $sender,
                recipient: $recipient
            )
        );

        $this->assertInstanceOf(Message::class, $message);
    }

    /** @test */
    public function should_create_a_new_chat_if_no_chat_was_specified()
    {
        $this->assertDatabaseCount('chats', 0);
        $sender = User::factory()->create();
        $recipient = User::factory()->create();

        (new CreateMessage())->execute(
            new CreateMessageInput(
                MessageType::TEXT,
                'hello',
                $sender,
                recipient: $recipient
            )
        );

        $this->assertDatabaseCount('chats', 1);
    }

    /** @test */
    public function should_notify_the_chat_participants_of_a_new_message()
    {
        Event::fake();
        $sender = User::factory()->create();
        $recipient = User::factory()->create();

        (new CreateMessage())->execute(
            new CreateMessageInput(
                MessageType::TEXT,
                'hello',
                $sender,
                recipient: $recipient
            )
        );

        Event::assertDispatched(MessageCreated::class);
    }
}
