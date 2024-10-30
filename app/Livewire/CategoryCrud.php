<?php

namespace App\Livewire;
use App\Models\Categories;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\ProductType;
class CategoryCrud extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $category;
    public $categoryName;
    public $deleteCategoryId;
    public $updateCategoryId;
    public $categories_;
    public $productType_id;

    public $search;
    public function addCategory(){

        try {
            $this->productType_id = ProductType::where('product_type', $this->productType_id)->first()->id;
            Categories::create([
                'product_type_id' => $this->productType_id,
                'category' => $this->category
            ]);
            session()->flash('add', 'Category added successfully');
            $this->productType_id = '';
            $this->category = '';
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to add category:');
        }

    }
    public function edit($id){
        $category = Categories::find($id);
        $this->category = $category->category;
        $this->updateCategoryId = $id;
    }

    public function updateCategory(){
        if ($this->updateCategoryId) {
            $category = Categories::find($this->updateCategoryId);
            if ($category) {
            $category->update([
                'category' => $this->categoryName
            ]);
            session()->flash('updateCategory', 'Category updated successfully');
            $this->category = '';
            $this->categoryName = null;
            } else {
            session()->flash('existCategory', 'Category not found');
            }
        } else {
            session()->flash('existCategory', 'Category does not exist');
        }
    }
    public function deleteCategory(){
        if ($this->deleteCategoryId) {
            $category = Categories::find($this->deleteCategoryId);
            if ($category) {
                $category->delete();
                $this->categories_ = Categories::all();
                $this->deleteCategoryId = null;
                session()->flash('delete', 'Category deleted successfully.');
            }
        }
    }
    public function close()
    {
        $this->reset();
    
    }
    public function render()
    {
        $query = Categories::query();
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('category', 'like', '%' . $this->search . '%');   
            });
            if ($query->count() == 0) {
                session()->flash('warning', 'No results found. Please enter a valid search term.');
            }
        }

        $categories = $query->paginate(10);
        return view('livewire.category-crud',[
            'categories' =>$categories,
        ]);
    }
}
