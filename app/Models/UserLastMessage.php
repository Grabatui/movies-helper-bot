<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id
 * @property int $message_id
 * @property string $type
 * @property string $data
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read User $user
 */
class UserLastMessage extends Model
{
    use HasTimestamps;

    protected $guarded = [];

    protected $primaryKey = 'user_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
