<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\order_detial;

class Order extends Model
{
    use HasFactory;

    public function order_detials()
    {
        return $this->hasMany(order_detial::class);
    }

    public function firstProduct()
    {
        return $this->hasOne(order_detial::class)->oldestOfMany();
    }
}
