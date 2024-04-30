<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class TrialItem extends Model
{
    use HasFactory;

    protected $fillable = [      
        'product_id',    
        'trial_product_id',   
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function trialProduct()
    {
        return $this->belongsTo(Product::class, 'trial_product_id');
    }
}
