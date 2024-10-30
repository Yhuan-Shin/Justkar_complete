<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Inventory;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    //
    function display(){
        $products = Products::all();
        return view('admin/admin-products', ['products' => $products]);
    }

    public function update(string $id ,Request $request){
       
        $product = Products::find($id);
        $product->discount = $request->input('discount');
        $product->discount_price = $product->price - ($product->discount * 0.01 * $product->price);
        

        $product->save();
        return redirect('admin/products')->with('success', 'Product updated successfully.');
    }
    // public function addToOrder(string $id ,Request $request){
    //     $cashierId = Auth::user()->id;        
    //     $product = Products::find($id);
    //     $orderItem = OrderItem::where('product_id', $product->id)->first();

    //     if (!$product) {
    //         return redirect('/cashier/pos')->with('error', 'Product not found!');
    //     }
    
    //     $orderItem = OrderItem::where('product_id', $product->id)
    //     ->where('cashier_id', $cashierId)
    //     ->first();    
    //    try {
    //     if ($orderItem) {
    //         return redirect('/cashier/pos')->with('error', 'Product is already in the cart!');
    //     } else {
    //         // If the product is not in the cart, create a new order item
    //         $orderItem = new OrderItem();
    //         $orderItem->cashier_id = $cashierId;
    //         $orderItem->product_id = $product->id;
    //         $orderItem->product_code = $product->product_code;
    //         $orderItem->product_name = $product->product_name;
    //         $orderItem->product_type = $product->product_type;
    //         $orderItem->price = $product->discount_price;
    //         $orderItem->size = $product->size;
    //         $orderItem->brand = $product->brand;
    //         $orderItem->category = $product->category;
    //         $orderItem->discount = $product->discount;
    //         $orderItem->discount_price = $product->discount_price;
    //         $orderItem->total_price = $product->discount_price;
    //         $orderItem->quantity = 1; // Default quantity
    //         $orderItem->save();
    //     }
    // } catch (\Exception $e) {
    //     return redirect('/cashier/pos')->with($e->getMessage());
    // }
    

    //     return redirect('/cashier/pos')->with('success', 'Product added to cart!');
    // }


}
