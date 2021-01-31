<?php

namespace App\Observers;

use App\Models\MoviesList;
use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        $defaultMoviesList = new MoviesList();
        $defaultMoviesList->name = 'Default';
        $defaultMoviesList->is_default = true;

        $defaultMoviesList->user()->associate($user);

        $defaultMoviesList->save();
    }
}
