<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sell extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $keyType = 'string';

    public $incrementing = false;

    function admin()  {
        return $this->belongsTo(Admin::class);
    }

    function customer()  {
        return $this->belongsTo(Customer::class);
    }
    function details()  {
        return $this->hasMany(SellDetails::class)->latest();
    }

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
