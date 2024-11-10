<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Support\Facades\Log;

class SellProductFilter
{
    public function __construct(protected $code)
    {
    
    }

    public function handle($builder, Closure $next)
    {
        if ($this->code) {
            return $builder->whereHas('details', function ($query) {
                $query->where(function ($query) {
                    $query->where('product_codes', $this->code)
                          ->orWhere('product_codes', 'LIKE', "{$this->code},%")
                          ->orWhere('product_codes', 'LIKE', "%,{$this->code},%")
                          ->orWhere('product_codes', 'LIKE', "%,{$this->code}");
                });
            });
        }

        return $next($builder);
    }
}
