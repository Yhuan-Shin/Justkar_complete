<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockNotification extends Model
{
    protected $table = 'stock_notifications';
    protected $fillable = ['inventory_id', 'message'];
    use HasFactory;

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }
}
