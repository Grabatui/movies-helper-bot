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
 * @property-read MoviesList $moviesList
 */
class Movie extends Model
{
    use HasTimestamps;

    protected $guarded = [];

    public function moviesList(): BelongsTo
    {
        return $this->belongsTo(MoviesList::class);
    }

    public function getFullName(): string
    {
        return sprintf('%s (%d) [%s] [#%d]', $this->name, $this->year, $this->moviesList->name, $this->id);
    }
}
