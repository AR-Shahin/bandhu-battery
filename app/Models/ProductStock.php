<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;
    protected $guarded = [];
    public const ADD = "add";
    public const REMOVE = "remove";

    public function getFlagBadgeAttribute()
    {
        return $this->flag == self::ADD ? '<span class="badge badge-success">Added</span>' : '<span class="badge badge-danger">Remove</span>';
    }


    function admin()  {
        return $this->belongsTo(Admin::class);
    }
    function product()  {
        return $this->belongsTo(Product::class);
    }

}
