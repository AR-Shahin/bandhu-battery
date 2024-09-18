<?php

namespace App\QueryFilters;

use Illuminate\Support\Facades\Log;

class CommonFilter extends Filter
{
    function __construct(protected string $dbColumn = "category_id", protected string|null $reqColumn)
    {
    }
    protected function filterValue(): string|null
    {
        return request($this->reqColumn);
    }

    protected function applyFilter($builder)
    {
        return $builder->where($this->dbColumn, $this->filterValue());
    }
}
