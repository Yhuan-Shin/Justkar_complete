<div wire:poll.active>
   

    <!-- Create Modal -->
    <div class="modal fade" id="inventoryAddModal" wire:ignore.self tabindex="-1" aria-labelledby="inventoryAddModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inventoryAddModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="submit">
                        @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                
                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="product_type">Product Type</label>
                        <select class="form-select" name="product_type" id="product_type" wire:model="selectedProduct" required>
                            <option value="">Select Product Type</option>
                            @foreach($product_type as $item)
                                <option value="{{ $item->id }}">{{ $item->product_type }}</option>
                            @endforeach
                        </select>
                        @error('product_type') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    @if(!is_null($categories))
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" wire:model="selectedCategory" required class="form-select">
                                <option value="">Select Category</option>
                                @foreach($categories as $item)
                                    <option value="{{ $item->id}}">{{ $item->category }}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    @endif
                        <div class="form-group">
                            <label for="product_code">Product Code</label>
                            <input type="text" maxlength="6" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase().replace(/\s/g, '')" id="product_code" class="form-control" wire:model="product_code" required>
                            @error('product_code') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" maxlength="50" id="product_name" style="text-transform:uppercase" wire:model="product_name" oninput="this.value = this.value.toUpperCase()" class="form-control" wire:model.debounce.200ms="query" autocomplete="off" required>
                            @error('product_name') <span class="text-danger">{{ $message }}</span> @enderror

                        @if(!empty($suggestions))
                            <div class="absolute bg-white border border-gray-300 mt-1 w-full z-10">
                                @foreach($suggestions as $suggestion)
                                    <div 
                                        class="p-2 cursor-pointer hover:bg-gray-100"
                                        wire:click="selectSuggestion('{{ $suggestion }}')"
                                    >
                                        {{ $suggestion }}
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        </div>
                      
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" min="1" id="quantity" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase(); if(this.value.startsWith('0')) this.value = this.value.slice(1);" class="form-control" wire:model="quantity" required>
                            @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <div class="d-flex align-items-center">
                                <select id="brand" class="form-select text-uppercase text-dark " wire:model="brand" required>
                                    <option value="" >Select Brand</option>
                                    @forelse($brands as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @empty
                                        <option value="">No Brands Available</option>
                                    @endforelse
                                </select>
                                
            

                            </div>
                        
                            @error('brand') <span class="text-danger">{{ $message }}</span> @enderror
                        
                          
                        </div>
                        
                
                        <div class="form-group">
                            <label for="size">Size</label>
                            <input type="text" id="size" class="form-control" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase().replace(/\s/g, '')" wire:model="size" required>
                            @error('size') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend3">₱</span>
                                <input type="number" class="form-control" min="1" onKeyPress="if(this.value.length==5) return false;" id="price" name="price" aria-label="Price" aria-describedby="inputGroupPrepend3" wire:model="price" required>
                            </div>
                          </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" id="description" class="form-control" style="text-transform:uppercase"  oninput="this.value = this.value.toUpperCase().replace(/\s/g, '')" wire:model="description"  required>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" accept=".jpg,.jpeg,.png. "id="product_image" wire:model="img"  name="product_image">
                            <div wire:loading wire:target="img">Uploading...</div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="close">Close</button>
                    <button type="button" class="btn btn-success" wire:click="submit" >Add</button>
                </div>
            </div>
        </div>
    </div>

</div>
