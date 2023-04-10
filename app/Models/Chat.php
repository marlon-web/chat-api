<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id,
 * @property ?string $name
 * @property ?string $photo
 * @property bool $is_group
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Chat extends Model
{
    use HasFactory;

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function addParticipant(User $participant)
    {
        $this->participants()->attach($participant->id);
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_participants');
    }
}
