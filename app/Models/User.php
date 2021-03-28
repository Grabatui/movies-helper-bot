<?php

namespace App\Models;

use App\Observers\UserObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $chat_id
 * @property string $external_id
 * @property string $name
 * @property string $language
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection $moviesLists
 *
 * @see UserObserver
 */
class User extends Model
{
    use HasTimestamps;

    protected $guarded = [];

    public function moviesLists(): HasMany
    {
        return $this->hasMany(MoviesList::class);
    }
}
