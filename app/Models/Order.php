<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\order_detial;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'paymentmethodid',
        'status',
        'address',
        'phone',
        'trains_time',
        'comment',
        'remit',
        'staff_id',
    ];

    public function details()
    {
        return $this->hasMany(order_detial::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
