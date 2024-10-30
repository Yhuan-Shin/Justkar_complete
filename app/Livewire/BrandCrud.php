<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;

class BrandCrud extends Component
{
    public $search;
    public $newBrand;
    public $editBrandId;
    public $brand;
    public $deleteBrandId;

    protected $rules = [
        'newBrand' => 'required|string|max:255',
        'brand' => 'required|string|max:255'
    ];

    public function editBrand($id)
    {
        $brand = Brand::find($id);
        $this->brand = $brand->name;
        $this->editBrandId = $id;
    }

    public function deleteBrand()
    {
        if ($this->deleteBrandId) {
            // Fetch and delete the brand
            $brand = Brand::find($this->deleteBrandId);
            if ($brand) {
                $brand->delete();
                
                // Refresh the brand list
                $this->brand = Brand::all();
                
                // Clear the selected brand ID
                $this->deleteBrandId = null;

                // Optionally add a flash message
                session()->flash('delete', 'Brand deleted successfully.');
            }
        }
    }
    public function close()
    {
        $this->reset();
    
    }


    public function updateBrand()
    {
        if ($this->editBrandId) {
            $brand = Brand::find($this->editBrandId);
            if ($brand) {
            $brand->update([
                'name' => $this->brand
            ]);
            session()->flash('update', 'Brand updated successfully');
            $this->brand = '';
            $this->editBrandId = null;
            } else {
            session()->flash('errorBrand', 'Brand not found.');
            }
        }else{
            session()->flash('errorBrand', 'Brand does not exist.');
        }
    }

    public function addBrand()
    {
        Brand::create([
            'name' => $this->newBrand
        ]);
        session()->flash('add', 'Brand added successfully');
        $this->newBrand = '';
    }

    public function render()
    {
        $query = Brand::query();    
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
            if ($query->count() == 0) {
                session()->flash('warning', 'No results found. Please enter a valid search term.');
            }
        }

        $brands = $query->paginate(10);
        return view('livewire.brand-crud', [
            'brands' => $brands
        ]);
    }
}
