<?php

namespace App\Repositories\Entity;

class MovieSearchParameters
{
    public string $searchString;

    public ?int $limit = null;

    public ?int $page = null;

    public function __construct(string $searchString)
    {
        $this->searchString = $searchString;
    }

    public function setPage(int $page, int $limit): void
    {
        $this->page = $page;

        $this->limit = $limit;
    }
}
