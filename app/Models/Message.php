<?php

namespace App\Models;

use App\Shared\Enums\MessageType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $author_id
 * @property int $chat_id
 * @property MessageType $type
 * @property string $content
 * @property User $author
 * @property Chat $chat
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Message extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => MessageType::class
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id', 'id');
    }
}
