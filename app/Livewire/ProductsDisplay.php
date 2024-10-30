<?php

namespace App\Livewire;
use App\Models\Products;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsDisplay extends Component
{
    use WithPagination;
    public $discount;
    public $discountPrice;
    public $search;
    public $filter;
    protected $paginationTheme = 'bootstrap';

    public function mount($search = null)
    {
        $this->search = $search;    

    }
    public function applyDiscount(){
        $validateData = $this->validate([
            'discount' => 'nullable|numeric',
        ]);
        $products = Products::where('archived', false)
                    ->whereNotNull('price')
                    ->get();

        foreach ($products as $product) {
            $this->discountPrice = $product->price - ($this->discount * 0.01 * $product->price);
    
            // Update the product's discount and discounted price
            $product->update([
                'discount' => $this->discount,
                'discount_price' => $this->discountPrice,
            ]);
        }

        session()->flash('discountApplied', 'Discount applied successfully');
    }

    public function render()
    {
        $brands = Products::where('archived', false)->distinct()->pluck('brand');
        // Base query to filter non-archived products
        $query = Products::where('archived', false)
        ->where('quantity', '>', 0)
        ->orderBy('created_at', 'desc');

        // Apply search filter if a search term is provided
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('product_name', 'like', '%' . $this->search . '%')
                  ->orWhere('product_code', 'like', '%' . $this->search . '%')
                  ->orWhere('brand', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%')
                  ->orWhere('size', 'like', '%' . $this->search . '%');
            });
            if ($query->count() == 0) {
                session()->flash('warning', 'No results found. Please enter a valid search term.');
            }
        }
        
        if ($this->filter) {
            $query->where('brand', $this->filter);
        }
        $products = $query->paginate(6);

       

        return view('livewire.products-display', [
            'products' => $products,
            'productsCount' => Products::where('archived', false)->count(),
            'brands' => $brands,
        ]);
    }
}

