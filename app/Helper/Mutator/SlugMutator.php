<?php
namespace App\Helper\Mutator;

use Illuminate\Support\Str;

trait SlugMutator
{

    function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

}
