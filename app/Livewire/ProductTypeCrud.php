<?php

namespace App\Livewire;
use App\Models\ProductType;
use Livewire\Component;

class ProductTypeCrud extends Component
{
    public $search;
    public $newProductType;
    public $productType;
    public $editProductTypeId;
    public $deleteProductTypeId;

    public function addProductType(){
        ProductType::create([
            'product_type' => $this->newProductType
        ]);
        session()->flash('add', 'Product Type added successfully');
        $this->newProductType = '';
    }
    public function close()
    {
        $this->reset();
    
    }
    public function deleteProductType(){
        if ($this->deleteProductTypeId) {
            // Fetch and delete the product type
            $productType = ProductType::find($this->deleteProductTypeId);
            if ($productType) {
                $productType->delete();
                
                // Refresh the product type list
                $this->productType = ProductType::all();
                
                // Clear the selected product type ID
                $this->deleteProductTypeId = null;
            }
        }
    }

    public function editProductType($id)
    {
        $type = ProductType::find($id);
        $this->productType = $type->name;
        $this->editProductTypeId = $id;
    }

    public function updateProductType()
    {
        if ($this->editProductTypeId) {
            // Fetch and update the product type
            $productType = ProductType::find($this->editProductTypeId);
            if ($productType) {
                $productType->update([
                    'product_type' => $this->productType
                ]);
                $this->productType = ProductType::all();
                $this->editProductTypeId = null;
            } else {
                session()->flash('existProductType', 'Product Type not found');
            }
        }else {
            session()->flash('existProductType', 'Product Type does not exist');
        }
    }
    public function render()
    {
        $query = ProductType::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('product_type', 'like', '%' . $this->search . '%');
            });

            if ($query->count() == 0) {
                session()->flash('warning', 'No results found. Please enter a valid search term.');
            }
        }

        $productTypes = $query->paginate(10);

        return view('livewire.product-type-crud',[
            'productTypes' => $productTypes]);
    }
}
