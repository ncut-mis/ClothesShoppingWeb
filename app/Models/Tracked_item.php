<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Tracked_item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',       
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
