<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $guarded = [];
    function getNameAttribute() {
        return $this->bn_name . " " . $this->en_name;
    }
}
