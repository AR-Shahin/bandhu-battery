<?php

namespace App\QueryFilters;

class PublicNewsBulkOptionFilter extends Filter
{
    function __construct(protected string|null $reqColumn)
    {
    }
    protected function filterValue(): string|null
    {
        return request($this->reqColumn);
    }

    protected function applyFilter($builder)
    {
        $filterConditions = [
            "pending" => function($query) {
                $query->where("status", 0);
            },
            "approved" => function($query) {
                $query->where("status", 1);
            },
            "rejected" => function($query) {
                $query->where("status", 2);
            },

            "order_asc" => function($query){
                $query->orderBy("id","asc");
            },
            "order_desc" => function($query){
                $query->orderBy("id","desc");
            },

        ];

        $filterValue = $this->filterValue();
        if (isset($filterConditions[$filterValue])) {
            $filterConditions[$filterValue]($builder);
        }

        return $builder;
    }

}
