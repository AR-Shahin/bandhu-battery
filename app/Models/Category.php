<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helper\Attribute\StatusAttribute;
use App\Helper\Mutator\SlugMutator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory,StatusAttribute,SlugMutator;
    protected $appends = ["name"];
    protected $guarded = [];

    function parent()  {
        return $this->belongsTo(Category::class,"parent_id")->withDefault([
            "bn_name" => "Root",
            "en_name" => "Root",
        ]);
    }

    function getNameAttribute() {
        return $this->bn_name . " " . $this->en_name;
    }

    function rootCategories()  {
        return self::whereNull("parent_id")->get();
    }
}
