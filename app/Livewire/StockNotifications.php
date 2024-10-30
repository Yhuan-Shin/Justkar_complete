<?php

namespace App\Livewire;

use App\Models\StockNotification;
use Livewire\Component;

class StockNotifications extends Component
{
    public function render()
    {
        $stock_notifications = StockNotification::with(['inventory' => function($query) {
            $query->select('id','status', 'product_code')
                  ->whereIn('status', ['outofstock', 'lowstock', 'instock']);
        }])
        ->select('id', 'product_code', 'message as status', 'created_at', 'inventory_id')
        ->orderBy('created_at', 'desc')
        ->get(); 

        return view('livewire.stock-notifications', ['stock_notifications' => $stock_notifications]);
    }
}
