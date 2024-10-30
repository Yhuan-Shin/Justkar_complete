<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsName extends Model
{
    use HasFactory;
    protected $table = 'products_name';

    protected $fillable = [
        'products_name',
    ];
}
