<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class SellDetails extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $keyType = 'string';

    public $incrementing = false;
    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }


    function product()  {
        return $this->belongsTo(Product::class);
    }
    function order()  {
        return $this->belongsTo(Sell::class,"sell_id");
    }
}
