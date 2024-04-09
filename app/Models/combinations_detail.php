<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Combination;

class combinations_detail extends Model
{
    use HasFactory;

    protected $table = 'combinations_detail';

    protected $fillable = [
        'combinations_id',
        'producted_id',
    ];

    public function Combination()
    {
        return $this->belongsTo(Combination::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

}
