<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

class Pagination
{
    public int $page;
    public int $size;

    public function __construct(int $page, int $size)
    {
        $this->page = $page;
        $this->size = $size;
    }

    public function applyPagination(Builder $query): Builder
    {
        return $query->skip(($this->page - 1) * $this->size)->take($this->size);
    }

    public function toArray(): array
    {
        return [
            'page' => $this->page,
            'size' => $this->size,
        ];
    }
}
