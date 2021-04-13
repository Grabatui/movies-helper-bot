<?php

namespace App\Repositories;

use App\Models\MoviesList;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class MoviesListRepository
{
    public static function getInstance(): self
    {
        return new static();
    }

    public function getAllByUser(User $user): Collection
    {
        return $user->moviesLists()->orderBy('is_default')->get();
    }

    /** @noinspection PhpIncompatibleReturnTypeInspection */
    public function getMoviesListByUserAndName(User $user, string $moviesListName): ?MoviesList
    {
        return $user->moviesLists()->where('name', $moviesListName)->first();
    }

    /** @noinspection PhpIncompatibleReturnTypeInspection */
    public function getMoviesListByUserAndId(User $user, int $moviesListId): ?MoviesList
    {
        return $user->moviesLists()->where('id', $moviesListId)->first();
    }
}
