<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

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
}
