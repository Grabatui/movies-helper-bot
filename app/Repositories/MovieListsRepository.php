<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class MovieListsRepository
{
    public static function getInstance(): self
    {
        return new static();
    }

    public function getAllByUser(User $user): Collection
    {
        return $user->moviesLists()->orderBy('is_default')->get();
    }
}
