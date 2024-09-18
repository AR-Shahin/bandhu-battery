<?php

namespace App\QueryFilters;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DateRangeFilter extends Filter
{
    function __construct(protected string|null $fromDate, protected string|null $toDate)
    {

    }
    protected function filterValue(): string|null
    {
        return "date_range";
    }

    protected function applyFilter($builder){
        Log::info("Date Range Filter Called " .$this->fromDate . " " . $this->toDate);
        if($this->fromDate && $this->toDate){
            if ($this->fromDate == $this->toDate){
                $this->toDate = Carbon::parse($this->toDate)->addDay(1);
            }
            return $builder->whereBetween("created_at",[$this->fromDate,$this->toDate]);
        }
        return $builder;
    }
}
