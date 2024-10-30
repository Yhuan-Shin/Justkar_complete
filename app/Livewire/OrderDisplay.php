<?php

namespace App\Livewire;
use App\Models\Products;
use Livewire\Component;

use App\Models\Inventory;
use App\Models\Sales;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem;


class OrderDisplay extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $orderItems;
    public $name;
    public $sales;
    public $amount;
    public $payment_method;
    public $ref_no;
    public $invoice_no;
    public $search;
    public function mount($search = null)
    {
        $this->search = $search;   
        $this->payment_method = ''; 
        $this->ref_no = '';
        $this->loadOrderItems(); 
    }
    public function loadOrderItems()
    {
        $this->orderItems = OrderItem::where('cashier_id', Auth::user()->id)->get();
        $this->name = Auth::user()->name;
        $this->sales = Sales::all();
    }
    public function addToCart(string $id){
        $cashierId = Auth::user()->id;        
        $product = Products::find($id);
        $orderItem = OrderItem::where('product_id', $product->id)->first();

        if (!$product) {
            session()->flash('warning', 'Product not found');
            return;
        }
    
        $orderItem = OrderItem::where('product_id', $product->id)
        ->where('cashier_id', $cashierId)
        ->first();    
       try {
        if ($orderItem) {
            session()->flash('warning', 'Product already in cart');
        } else {
            // If the product is not in the cart, create a new order item
            $orderItem = new OrderItem();
            $orderItem->cashier_id = $cashierId;
            $orderItem->product_id = $product->id;
            $orderItem->product_code = $product->product_code;
            $orderItem->product_name = $product->product_name;
            $orderItem->product_type = $product->product_type;
            $orderItem->price = $product->discount_price;
            $orderItem->size = $product->size;
            $orderItem->brand = $product->brand;
            $orderItem->category = $product->category;
            $orderItem->discount = $product->discount;
            $orderItem->discount_price = $product->discount_price;
            $orderItem->total_price = $product->discount_price;
            $orderItem->quantity = 1; // Default quantity
            $orderItem->save();
            $this->dispatch('refreshCart');
        }
    } catch (\Exception $e) {
        session()->flash('error', $e->getMessage());
    }
    

        session()->flash('success', 'Product added to cart successfully!');
    }
    public function increment($id)
    {
        $orderItem = OrderItem::findOrFail($id);
    
        $inventory = Inventory::where('product_code', $orderItem->product_code)->first();
        if ($orderItem->quantity < $inventory->quantity) {
            $orderItem->quantity += 1;
            $orderItem->total_price = $orderItem->quantity * $orderItem->price;
            $orderItem->save();
        }
        else{
            session()->flash('quantity', 'Cannot add more than available quantity');
        }
        $this->loadOrderItems();
    }

    public function decrement($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        if ($orderItem->quantity > 1) {
            $orderItem->quantity -= 1;
            $orderItem->total_price = $orderItem->quantity * $orderItem->price;
            $orderItem->save();
        }
        $this->loadOrderItems();
    }

    public function deleteItem($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();
        $this->loadOrderItems();
    }
    public function updateQuantity($id, $quantity)
    {
        $orderItem = OrderItem::findOrFail($id);
        $inventory = Inventory::where('product_code', $orderItem->product_code)->first();
    
        // Check if the entered quantity is within the available inventory limit
        if ($quantity >= 1 && $quantity <= $inventory->quantity) {
            $orderItem->quantity = $quantity;
            $orderItem->total_price = $orderItem->quantity * $orderItem->price;
            $orderItem->save();
        } elseif ($quantity > $inventory->quantity) {
            session()->flash('quantity', 'Cannot exceed available inventory quantity');
            // Reset to maximum available inventory if the user tries to go over
            $orderItem->quantity = $inventory->quantity;
            $orderItem->total_price = $orderItem->quantity * $orderItem->price;
            $orderItem->save();
        }
    
        $this->loadOrderItems();  // Refresh order items
    }
    public function render()
    {
        $query = Products::where('archived', false)
                 ->whereNotNull('price')
                 ->where('quantity', '>', 0)
                 ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('product_name', 'like', '%' . $this->search . '%')
                  ->orWhere('product_code', 'like', '%' . $this->search . '%')
                  ->orWhere('brand', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%')
                  ->orWhere('size', 'like', '%' . $this->search . '%');

            });
        }

        $products = $query->paginate(10);

        if ($products->isEmpty()) {
            session()->flash('warning', 'No results found for ' . $this->search);
        }

        return view('livewire.order-display', [
            'products' => $products,
            'productsCount' => Products::where('archived', false)->count(),
            'total' => OrderItem::where('cashier_id', Auth::user()->id)->sum('total_price'),
            'order'=> OrderItem::where('cashier_id', Auth::user()->id)->get(),
        ]);
    }
}
