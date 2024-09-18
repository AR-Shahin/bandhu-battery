<?php

namespace App\QueryFilters;

class NewsBulkOptionFilter extends Filter
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
            "pub" => function($query) {
                $query->where("status", 1);
            },
            "not_pub" => function($query) {
                $query->where("status", 0);
            },
            "top" => function($query) {
                $query->where("is_top", 1);
            },
            "special" => function($query) {
                $query->where("is_special", 1);
            },
            "future" => function($query) {
                $query->whereNotNull("future_date");
            },
            "default" => function($query) {
                $query->where("is_default",1);
            },
            "trash" => function($query){
                $query->whereNotNull("deleted_at");
            },
            "order_asc" => function($query){
                $query->orderBy("order","asc");
            },
            "order_desc" => function($query){
                $query->orderBy("order","desc");
            },
            "home_news" => function($query){
                $query->where("is_home_five",1);
            },
            "home_division_news" => function($query){
                $query->where("is_district_home",1);
            },
            "correspondent" => function($query){
                $query->where("news_type","correspondent");
            },
            "public" => function($query){
                $query->where("news_type","public");
            }
        ];

        $filterValue = $this->filterValue();
        if (isset($filterConditions[$filterValue])) {
            $filterConditions[$filterValue]($builder);
        }

        return $builder;
    }

}
