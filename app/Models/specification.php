<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class specification extends Model
{
    use HasFactory;

    protected $table = 'specification';
    protected $fillable = [
        'product_id',
        'name',       
    ];

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }
}
