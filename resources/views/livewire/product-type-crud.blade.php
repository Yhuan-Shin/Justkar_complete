<div wire:poll.3000ms>
    {{-- Add Product Type Modal --}}
    <div class="modal fade" id="addProductTypeModal" wire:ignore.self tabindex="-1" aria-labelledby="addProductTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addProductTypeModalLabel">Add Product Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="addProductType">
                        @if (session()->has('add'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('add') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="product_type_name">Product Type Name</label>
                            <input type="text" class="form-control" id="product_type_name" wire:model="newProductType"  required>
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

    {{-- Edit Product Type Modal --}}
    <div class="modal fade" id="updateProductTypeModal" wire:ignore.self tabindex="-1" aria-labelledby="editProductTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editProductTypeModalLabel">Edit Product Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Select the product type you want to edit</h6>
                    <input type="text" class="form-control mb-2" placeholder="Search product type..." id="search" wire:model="search">

                    <form wire:submit.prevent="updateProductType">
                        @if (session()->has('update'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('update') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session()->has('existProductType'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('existProductType') }}
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
                            @foreach ($productTypes as $productType)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="editProductType" id="editProductType{{ $productType->id }}" wire:model="editProductTypeId" value="{{ $productType->id }}">
                                    <label class="form-check-label" for="editProductType{{ $productType->id }}">
                                        {{ $productType->product_type }}
                                    </label>
                                </div>
                            @endforeach
                            {{ $productTypes->links() }}

                        </div>

                        <div class="form-group">
                            <label for="product_type_name">Product Type Name</label>
                            <input type="text" class="form-control" id="product_type_name" wire:model="productType"  required>
                        </div>
                        @error('productType') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="close">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                    </form>
            </div>
        </div>
    </div>

    {{-- Delete Product Type Modal --}}
    <div class="modal fade" id="deleteProductTypeModal" wire:ignore.self tabindex="-1" aria-labelledby="deleteProductTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteProductTypeModalLabel">Delete Product Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Select the product type you want to delete</h6>

                    <input type="text" class="form-control mb-2" id="search"  placeholder="Search product type..." wire:model="search">

                    <form wire:submit.prevent="deleteProductType">
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
                            @foreach ($productTypes as $productType)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="deleteProductType" id="deleteProductType{{ $productType->id }}" wire:model="deleteProductTypeId" value="{{ $productType->id }}">
                                    <label class="form-check-label " for="deleteProductType{{ $productType->id }}">
                                        {{ $productType->product_type }}
                                    </label>
                                </div>
                            @endforeach
                            {{ $productTypes->links() }}
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
