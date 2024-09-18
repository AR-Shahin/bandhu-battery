<?php

namespace App\QueryFilters;

abstract class Filter
{
    public function handle($request, \Closure $next)
    {
        if (!$this->filterValue()) {
            return $next($request);
        }

        $builder = $next($request);
        return $this->applyFilter($builder);
    }

    protected abstract function filterValue();

    protected abstract function applyFilter($builder);
}
