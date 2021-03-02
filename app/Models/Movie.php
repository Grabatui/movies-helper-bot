<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property int $year
 * @property string $note
 * @property int $movies_list_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read MoviesList $list
 */
class Movie extends Model
{
    use HasTimestamps;

    protected $guarded = [];

    public function list(): BelongsTo
    {
        return $this->belongsTo(MoviesList::class);
    }
}
