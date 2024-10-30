<div wire:poll.3000ms>
   <div class="container mt-3">
    @if(session()->has('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    @if(session()->has('discountApplied'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('discountApplied') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row mb-4 align-items-center">
        <div class="col-md-4 mb-2">
            <input type="text" wire:model="search" placeholder="Search product..."  name="search" id="search" class="form-control">
        </div>
        <div class="col-md-4 mb-2">
            <div class="input-group">
                <span class="input-group-text">%</span>
                <input type="number" wire:model="discount" placeholder="Apply discount to all" name="discount" id="discount" class="form-control" onKeyPress="if(this.value.length==3) return false;">
                <button class="btn btn-success" type="button" id="button" wire:click="applyDiscount">Apply</button>

            </div>
        </div>
        <div class="col-md-2 mb-2">
            <select name="filter" wire:model="filter" class="form-select" >
                <option value="">All</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand }}">{{ $brand }}</option>
                @endforeach
                
            </select>
        </div>
    </div>
   </div>
    <div class="row mt-3">
        @livewire('edit-product')

            <div class="container">
              <div class="row">
                @foreach ($products as $item)
                <div class="col-md-4 mb-3 d-flex justify-content-center">
                  <div class="card text-black" style="width: 18rem;">
                    @if($item->product_image == null)
                    <p class="alert alert-danger">No Image</p>
                    @else
                    <img src="{{ asset('storage/'.$item->product_image) }}" class="card-img-top p-5" style="height: 100%; width: 100%; ">
                    @endif
                    <div class="card-body">
                      <div class="text-center">
                        <h5 class="card-title">{{ $item->product_name }}</h5>
                        <p class="text-muted mb-4">{{ $item->brand }}</p>
                      </div>
                      <div>
                        <div class="d-flex justify-content-between">
                          <span>{{ $item->product_type }}</span><span>{{ $item->product_code }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                          <span>{{ $item->category }}</span><span>{{ $item->size }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                          @if($item->quantity == 0)
                          <span class="badge bg-danger">Out of Stock</span>
                          @elseif($item->quantity <= $item->critical_level)
                          <span class="badge bg-warning">Low Stock</span>
                          @else
                          <span class="badge bg-success">In Stock</span>
                          @endif
                        </div>
                      </div>
                      <div class="d-flex justify-content-between total font-weight-bold mt-4">
                        @if($item->price == null)
                        <p class="alert alert-danger">No Price Set</p>
                        @else
                        @if($item->discount == null)
                        <span>₱{{ number_format($item->price,2) }}</span>
                        @else
                        <span class="text-decoration-line-through">₱{{ number_format($item->price,2) }}</span>
                        <span>₱{{ number_format($item->discount_price,2) }}</span>
                        @endif
                        @endif
                      </div>
                      @if($item->discount > 0)
                        {{ $item->discount }}% OFF
                      @endif
                      <div class="d-flex justify-content-center">
                        <button class="btn btn-primary" data-bs-target="#edit-product{{ $item->id }}" data-bs-toggle="modal">Edit</button>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
        @if($productsCount== 0)
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fs-4 bi bi-exclamation-circle-fill p-3"></i> No items in inventory
            </div>
        @endif
    </div>

    {{ $products->links() }}
</div>

