<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Support\Facades\Log;

class SellProductFilter
{
    function __construct( protected $productId)
    {
    }

    public function handle($builder,Closure $next)
    {
        if($this->productId){
            return $builder->whereHas('details', function ($query) {
                $query->where('product_id', $this->productId);
            });
        }
        return $next($builder);
    }
}
