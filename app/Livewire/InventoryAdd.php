<?php

namespace App\Livewire;
use App\Models\Brand;
use App\Models\Categories;
use App\Models\Inventory;
use App\Models\Products;
use App\Models\ProductType;
use App\Models\ProductsName;
use App\Models\StockNotification;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Database\QueryException;
class InventoryAdd extends Component
{
    use WithFileUploads;
    public $product_code;
    public $product_name;
    public $selectedProduct = null;
    public $selectedCategory = null;
    public $quantity;
    public $brand;
    public $size;
    public $description;
    public $inventory;
    public $img;
    public $price;
    public $categories= null;
    
    public $newBrand;   

    public $query = '';
    public $suggestions = [];
 
    protected $rules = [
        'product_code' => 'required|unique:products,product_code',
        'product_name' => 'required|',
        'selectedProduct' => 'required',
        'selectedCategory' => 'required',
        'quantity' => 'required|numeric|min:1',
        'brand' => 'required',
        'size' => 'required',
        'description' => 'required',
        'price' => 'required',
        'img'=>'required|image|mimes:jpeg,png,jpg,svg|max:2048',
    ];

    public function close()
    {
        $this->reset();
    }
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
    public function updatedSelectedProduct($product_type_id){
        $this->categories = Categories::where('product_type_id', $product_type_id)->select('id', 'category')->get();
    }
    
   
    public function submit()
    {
        $this->validate();

        $img_path = $this->img->store('photos', 'public'); 


        $data = [
            'product_code' => $this->product_code,
            'product_name' => $this->query ?? $this->product_name,
            'product_type' => ProductType::where('id', $this->selectedProduct)->value('product_type'),
            'category' => Categories::where('id', $this->selectedCategory)->value('category'),
            'quantity' => $this->quantity,
            'brand' => Brand::where('id', $this->brand)->value('name'),
            'size' => $this->size,
            'price' => $this->price,
            'img' => $img_path,
            'description' => $this->description
        ];
        $critical_level = Inventory::latest()->value('critical_level') ?? 0;

        $existingInventory = Inventory::where('product_name', $data['product_name'])
                ->where('brand', $data['brand'])
                ->where('size', $data['size'])
                ->where('product_type', $data['product_type'])
                ->where('category', $data['category'])
                ->where('description', $data['description'])
                ->first();
        try {

            if ($existingInventory) {
                session()->flash('error', 'Product already exists.');
            }else{
                $status = ($data['quantity'] > $critical_level) ? 'instock' : 'lowstock';
            
                $inventory = Inventory::create([
                    'product_code' => $data['product_code'],
                    'product_name' => $data['product_name'],
                    'product_type' => $data['product_type'],
                    'category' => $data['category'],
                    'quantity' => $data['quantity'],
                    'brand' => $data['brand'],
                    'size' => $data['size'],
                    'critical_level' => $critical_level,
                    'status' => $status,
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'img' => $img_path,

                ]);
                $inventory->save();


                Products::create([
                    'inventory_id' => $inventory->id,
                    'product_code' => $inventory->product_code,
                    'product_name' => $inventory->product_name,
                    'category' => $inventory->category,
                    'quantity' => $inventory->quantity,
                    'brand' => $inventory->brand,
                    'product_type' => $inventory->product_type,
                    'size' => $inventory->size,
                    'discount' => 0,
                    'description' => $inventory->description,
                    'critical_level' => $critical_level,
                    'price' => $inventory->price,
                    'product_image' => $inventory->img,
                ]);

                StockNotification::create([
                    'inventory_id' => $inventory->id,
                    'message' => $inventory->status === 'lowstock' || $inventory->status === 'outofstock' || $inventory->status === 'instock' ? $inventory->status : StockNotification::latest()->value('message'),
                    'product_code' => $inventory->product_code,
                ]);

                $this->close();

                session()->flash('success', 'Item Inserted');
                // return redirect()->route('inventory.store')->with('success', 'Item Inserted');

            }
           
        
        
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                session()->flash('product_code', 'Duplicate entry for product code. Please use a different product code.');
                return;
            } else {
                throw $e;
            }
        }
    }
    public function refresh()
    {
        $this->render();
        
    }
    public function render()
    {
        return view('livewire.inventory-add',[
            'product_type'=> ProductType::all(),
            'brands' => Brand::all(),
        ]);
    }
}