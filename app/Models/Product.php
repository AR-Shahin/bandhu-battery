<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    function category() {
        return $this->belongsTo(Category::class);
    }

    function brand() {
        return $this->belongsTo(Brand::class);
    }
    function unit() {
        return $this->belongsTo(Unit::class);
    }
    function created_by() {
        return $this->belongsTo(Admin::class,"admin_id");
    }
    function vendor() {
        return $this->belongsTo(Vendor::class);
    }

    function stock_history()  {
        return $this->hasMany(ProductStock::class,"product_id");
    }

    function sells()  {
        return $this->hasMany(Sell::class);
    }
    function update_stock($stock,$flag,$remarks) {
        $this->stock_history()->create([
            "stock" => $stock,
            "flag" => $flag,
            "remarks" => $remarks,
            "admin_id" => auth()->id() ?? 1
        ]);
    }
}
