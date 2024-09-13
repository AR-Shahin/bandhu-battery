<?php

namespace App\Models;

use App\Helper\Attribute\StatusAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory,StatusAttribute;
    protected $guarded = [];
    function getNameAttribute() {
        return $this->bn_name . " " . $this->en_name;
    }
}
