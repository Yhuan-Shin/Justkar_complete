<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Categories;
use Illuminate\Database\QueryException;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\ProductsName;
use App\Models\ProductType;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class InventoryUpdate extends Component
{
    use WithFileUploads;
   // Inventory
   public $item;
   public $itemId;
   public $product_code;
   public $product_name;
   public $category;
   public $quantity;
   public $brand;
   public $size;
   public $description;
   public $price;
   public $img;
   public $new_image;
   
   // dependent dropdown
   public $selectedProduct;
   public $selectedCategory;
   public $product_types;
   public $categories = [];

   public $newBrand;

   public $query = '';
    public $suggestions = [];

   protected $listeners = ['openModal'=> 'edit'];
   protected $rules = [
       'product_code' => 'required',
       'product_name' => 'required',
       'selectedCategory' => 'required',
       'selectedProduct' => 'required',
       'quantity' => 'required',
       'brand' => 'required',
       'size' => 'required',
       'description' => 'required',
       'price' => 'required',
       'new_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
   ];
   public function updatedQuery()
    {
        // Fetch suggestions based on the current query
        $this->suggestions = ProductsName::where('products_name', 'LIKE', "%{$this->query}%")->pluck('products_name')
        ->take(5);
    }
    
 
    public function selectSuggestion($suggestion)
    {
        $this->query = $suggestion; // Set the input field value to the selected suggestion
        $this->suggestions = []; // Clear suggestions
    }
   public function mount(){
       $this->item = Inventory::where('archived', 0)->get();
       $this->product_types = ProductType::all();
       $this->brand = Brand::all();
       $this->categories = Categories::where('product_type_id', $this->selectedProduct)->select('id', 'category')->get();

   }
   public function updatedSelectedProduct($product_type_id)
   {
       $this->categories = Categories::where('product_type_id', $product_type_id)->select('id', 'category')->get();
   }

     public function edit($id)
   {
       $item = Inventory::find($id);
       $this->itemId = $id;
       $this->product_code = $item->product_code;
       $this->product_name = $item->product_name;
       $this->selectedProduct = ProductType::where('id', $item->product_type)->value('id');
       $this->selectedCategory = Categories::where('id', $item->category)->value('id');
       $this->quantity = $item->quantity;
       $this->brand = Brand::where('id', $item->brand)->value('name');
       $this->size = $item->size;
       $this->description = $item->description;
       $this->price = $item->price;
       $this->img = $item->img;
       $this->dispatch('open-modal');
   }

   public function update()
{
     $this->validate();
     try {
          $item = Inventory::find($this->itemId);
          $existingInventory = Inventory::where('product_name', $this->product_name)
          ->where('brand', Brand::where('id', $this->brand)->value('name'))
          ->where('size', $this->size)
          ->where('product_type', ProductType::where('id', $this->selectedProduct)->value('product_type'))
          ->where('category', Categories::where('id', $this->selectedCategory)->value('category'))
          ->where('description', $this->description)
          ->where('id', '!=', $this->itemId) 
          ->first();
          if ($existingInventory) {
                session()->flash('update_error', 'Product already exists.');
                return; // Stop further execution
          }

          $img_path = $this->img;
          if ($this->new_image) {
                // Store the new image
                $img_path = $this->new_image->store('photos', 'upload');

                // Optionally delete the old image
                if ($this->img) {
                     Storage::disk('public')->delete($this->img);
                }
          }

          $data = [
                'product_code' => $this->product_code,
                'product_name' => $this->query ?: $this->product_name,
                'product_type' => ProductType::where('id', $this->selectedProduct)->value('product_type'),
                'category' => Categories::where('id', $this->selectedCategory)->value('category'),
                'quantity' => $this->quantity,
                'brand' => Brand::where('id', $this->brand)->value('name'),
                'size' => $this->size,
                'price' => $this->price,
                'img' => $img_path,
                'description' => $this->description
          ];

          $item->update($data);

          session()->flash('update_success', 'Item updated successfully.');
     } catch (QueryException $e) {
          session()->flash('error', 'An error occurred while updating the item.');
     }
}
  
    public function render()
    {
        return view('livewire.inventory-update',['brands' => Brand::all()]);
    }
}
