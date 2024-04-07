<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\combinations_detail;

class Combination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_id',
        'staff_id',
        'price'
    ];

    public function combinations_detail()
    {
        return $this->hasMany(combinations_detail::class , 'combinations_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
