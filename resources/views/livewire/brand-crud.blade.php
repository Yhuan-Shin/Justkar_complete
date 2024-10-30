<div  wire:poll.3000ms>
    {{-- Add Brand Modal --}}
    <div class="modal fade" id="addBrandModal" wire:ignore.self tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addBrandModalLabel">Add Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form wire:submit.prevent="addBrand">
                        @if (session()->has('add'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('add') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

            
                        <div class="form-group">
                            <label for="brand_name">Brand Name</label>
                            <input type="text" class="form-control" id="brand_name" wire:model="newBrand" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase().replace(/\s/g, '')" required>
                        </div>
                        @error('newBrand') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="close">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                    </form>
            </div>
        </div>
    </div>

    {{-- Edit Brand Modal --}}
    <div class="modal fade" id="updateBrandModal" wire:ignore.self tabindex="-1" aria-labelledby="editBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editBrandModalLabel">Edit Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Select the brand you want to edit</h6>
                    <input type="text" class="form-control mb-2" id="search"  placeholder="Search product type..." wire:model="search">

                    <form wire:submit.prevent="updateBrand">
                        @if (session()->has('update'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('update') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session()->has('errorBrand'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('errorBrand') }}
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
                            @foreach ($brands as $brand)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="editBrand" id="editBrand{{ $brand->id }}" wire:model="editBrandId" value="{{ $brand->id }}">
                                    <label class="form-check-label" for="editBrand{{ $brand->id }}">
                                        {{ $brand->name }}
                                    </label>
                                </div>
                            @endforeach
                            {{ $brands->links() }}
                        </div>

                        <div class="form-group">
                            <label for="brand_name">Brand Name</label>
                            <input type="text" class="form-control" id="brand_name" wire:model="brand" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase().replace(/\s/g, '')" required>
                        </div>
                        @error('brand') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="close">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                    </form>
            </div>
        </div>
    </div>

    {{-- Delete Brand Modal --}}
    <div class="modal fade" id="deleteBrandModal" wire:ignore.self tabindex="-1" aria-labelledby="deleteBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteBrandModalLabel">Delete Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Select the brand you want to delete</h6>
                    <input type="text" class="form-control mb-2" id="search"  placeholder="Search product type..." wire:model="search">
                    <form wire:submit.prevent="deleteBrand">
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
                            @foreach ($brands as $brand)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="deleteBrand" id="deleteBrand{{ $brand->id }}" wire:model="deleteBrandId" value="{{ $brand->id }}">
                                    <label class="form-check-label" for="deleteBrand{{ $brand->id }}">
                                        {{ $brand->name }}
                                    </label>
                                </div>
                            @endforeach
                            {{ $brands->links() }}
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
