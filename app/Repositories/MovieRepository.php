<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Models\MoviesList;

class MovieRepository
{
    public static function getInstance(): self
    {
        return new static();
    }

    public function create(MoviesList $moviesList, string $name, int $year, string $note = ''): Movie
    {
        $movie = new Movie();
        $movie->name = $name;
        $movie->year = $year;
        $movie->note = $note;

        $movie->moviesList()->associate($moviesList);

        $movie->save();

        return $movie;
    }
}
