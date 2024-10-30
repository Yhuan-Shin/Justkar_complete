<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_type_id',
        'category',
    ];
    public function product_type(){
        return $this->hasMany(ProductType::class);
    }
}
