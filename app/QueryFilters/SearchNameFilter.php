<?php
namespace App\QueryFilters;

use Closure;
use Illuminate\Http\Request;

class SearchNameFilter
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle($query, Closure $next)
    {
        if ($this->request->q_name) {
            $query->where($this->request->col_name_db, 'like', '%' . $this->request->q_name . '%');
        }

        return $next($query);
    }
}
