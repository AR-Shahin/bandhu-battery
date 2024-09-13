<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    use HasFactory;
    protected $guarded = [];

    function admin()  {
        return $this->belongsTo(Admin::class);
    }

    function customer()  {
        return $this->belongsTo(Customer::class);
    }
    function details()  {
        return $this->hasMany(SellDetails::class)->latest();
    }
}
