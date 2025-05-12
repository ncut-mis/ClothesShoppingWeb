<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\CartItem;
use App\Models\Combination;
use App\Models\combinations_detail;
use App\Models\order_detial;
use App\Models\Tracked_item;
use App\Models\specification;
use App\Models\stock;
use App\Models\TrialItem;
use App\Models\ProductPhoto;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'size',
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
    public function trackItem()
    {
        return $this->hasMany(Tracked_item::class);
    }

    public function productPhotos()
    {
        return $this->hasMany(ProductPhoto::class)->orderBy('sort_order');
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

    public function Specification()
    {
        return $this->hasMany(specification::class);
    }

    public function Stock()
    {
        return $this->hasMany(stock::class);
    }

    public static function Track_isExist($productID){
        $exist = Tracked_item::Where('product_id','=',$productID)->exists();
        return $exist;
    }

    public function TrialItem()
    {
        return $this->hasMany(TrialItem::class);
    }
}
