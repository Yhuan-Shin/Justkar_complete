<div wire:poll.3000ms>
    {{-- Add Category Modal --}}
    <div class="modal fade" id="addCategoryModal" wire:ignore.self tabindex="-1" aria-labelledby="addCategoryModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addCategoryModal">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="addCategory">
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session()->has('add'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('add') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="product_type_name">Enter the Product Type According to the Category</label>
                            <input type="text" class="form-control" id="product_type_name" wire:model="productType_id" required>
                        </div>
                        <div class="form-group">
                            <label for="category_name">Category </label>
                            <input type="text" class="form-control" id="category_name" wire:model="category"  required>
                        </div>
                        @error('newProductType') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="close">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                    </form>
            </div>
        </div>
    </div>

    {{-- Edit Category Modal --}}
    <div class="modal fade" id="updateCategoryModal" wire:ignore.self tabindex="-1" aria-labelledby="updateCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="updateCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Select the category you want to edit</h6>
                    <input type="text" class="form-control mb-2" id="search" wire:model="search">
                    <form wire:submit.prevent="updateCategory">
                        @if (session()->has('updateCategory'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('updateCategory') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session()->has('existCategory'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('existCategory') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session()->has('warning'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('warning') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif


                        <div class="form-group">
                            @foreach ($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="updateCategory" id="updateCategory{{ $category->id }}" wire:model="updateCategoryId" value="{{ $category->id }}" required>
                                    <label class="form-check-label" for="updateCategory{{ $category->id }}">
                                        {{ $category->category }}
                                    </label>
                                </div>
                            @endforeach
                            {{ $categories->links() }}
                        </div>

                        <div class="form-group">
                            <label for="product_type_name">Category</label>
                            <input type="text" class="form-control" id="category_name" wire:model="categoryName" required>
                        </div>
                        @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="close">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                    </form>
            </div>
        </div>
    </div>

    {{-- Delete Category Type Modal  --}}
    <div class="modal fade" id="deleteCategoryModal" wire:ignore.self tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteCategoryModalLabel">Delete Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Select the category you want to delete</h6>
                    <input type="text" class="form-control mb-2" id="search" wire:model="search">

                    <form wire:submit.prevent="deleteCategory">
                        @if (session()->has('delete'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('delete') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session()->has('warning'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                        </div>
                     @endif
                        <div class="form-group">
                            @foreach ($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="deleteCategoryId" id="deleteCategoryId{{ $category->id }}" wire:model="deleteCategoryId" value="{{ $category->id }}" >
                                    <label class="form-check-label " for="deleteCategoryId{{ $category->id }}">
                                        {{ $category->category }}
                                    </label>
                                </div>
                            @endforeach
                            {{ $categories->links() }}
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="close">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
                    </form>
            </div>
        </div>
    </div>
</div>
