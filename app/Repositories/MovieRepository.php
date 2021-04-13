<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Models\MoviesList;
use App\Repositories\Entity\MovieSearchParameters;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    public function search(MovieSearchParameters $searchParameters): LengthAwarePaginator
    {
        return Movie::query()
            ->where('name', 'like', '%' . $searchParameters->searchString . '%')
            ->orWhere('year', $searchParameters->searchString)
            ->paginate($searchParameters->limit, ['*'], 'page', $searchParameters->page);
    }
}
