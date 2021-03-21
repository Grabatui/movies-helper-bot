<?php

namespace App\Models;

use App\Observers\UserObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $chat_id
 * @property string $external_id
 * @property string $name
 * @property string $language
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @see UserObserver
 */
class User extends Model
{
    use HasTimestamps;

    protected $guarded = [];
}
