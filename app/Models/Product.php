<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\CartItem;
use App\Models\Combination;
use App\Models\combinations_detail;
use App\Models\order_detial;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'stock',
        'price',
        'description',
        'is_shelf',
        'category_id',
    ];

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function ProductPhoto()
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function firstPhoto()
    {
    return $this->hasOne(ProductPhoto::class)->oldestOfMany();
    }

    public function order_detial()
    {
        return $this->hasMany(order_detial::class);
    }

    public function Combination()
    {
        return $this->hasMany(Combination::class);
    }

    public function combinations_detail()
    {
        return $this->hasMany(combinations_detail::class);
    }
}
