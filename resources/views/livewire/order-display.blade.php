<div wire:poll.3000ms>
    {{-- delete modal --}}
    @foreach($order as $item)
    <div class="modal fade" id="modal-delete{{ $item->id }}" wire:ignore.self tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item from the cart?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('order.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"  class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    {{-- confirm checkout --}}
    <div class="modal fade" id="confirmCheckoutModal" wire:ignore.self tabindex="-1" aria-labelledby="confirmCheckoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmCheckoutModalLabel">Generate Receipt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        @foreach($order as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                <h6> {{ $item->product_name }} - {{$item->quantity}}</h6>
                                    <small class="text-muted">{{ $item->size }}</small>
                                </div>
                                <span class="text-muted">₱{{ number_format($item->total_price,2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                  
                    <p class="text-end mt-2">Total: ₱{{ number_format($total,2) }}</p>

                    <hr>

                    <form action="{{ route('order.checkout') }}" method="POST" autocomplete="off"> 
                        @csrf
                        @method('POST')
                    <h6>Payment Method:</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" wire:model="payment_method" required>
                        <label class="form-check-label" for="cash">
                            Cash
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="gcash" value="gcash" wire:model="payment_method" required>
                        <label class="form-check-label" for="gcash">
                            GCash
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" wire:model.defer="payment_method" required>
                        <label class="form-check-label" for="check">
                             Card
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment_method" id="Bank" value="bank" wire:model.defer="payment_method" required>
                        <label class="form-check-label" for="Bank">
                            Bank Transfer
                        </label>
                    </div>
                    <h6 >Enter Payment Amount</h6>
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text">₱</span>
                       
                            <input type="text" name="amount" wire:model="amount" class="form-control" 
                            aria-label="Dollar amount (with dot and two decimal places)" style="appearance: textfield" 
                            required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                            @if($payment_method === 'gcash' || $payment_method === 'bank' || $payment_method === 'credit_card')
                            placeholder="{{ number_format($total,2) }}"
                            @endif
                            >
                            
                    </div>
                    <label for="ref_no">Reference No:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">REF-</span>
                        <input type="number" onKeyPress="if(this.value.length==30) return false;" name="ref_no" wire:model="ref_no" class="form-control" style="appearance: textfield" required 
                        @if($payment_method === 'cash') 
                        disabled 
                        value=""
                        placeholder="Reference No. for Online Payment Only"
                        @endif
                        @if($payment_method =='gcash' || $payment_method =='bank' || $payment_method =='credit_card')
                        placeholder="Reference No. for Online Payment Only"
                        @else
                        disabled
                        @endif

                        >
                    </div>
                    <label for="invoice_no">Invoice No:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">INV-</span>
                        <input type="number" onKeyPress="if(this.value.length==30) return false;" name="invoice_no" wire:model="invoice_no" class="form-control"  style="appearance: textfield"   required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-file-earmark-pdf-fill"></i> Generate Receipt
                    </button>
                 </form>

                </div>
            </div>
        </div>
    </div>
    {{-- main container --}}
      
    <div class="container">
        <div class="row">
            {{-- Products Section --}}
            <div class="col">
                <div class="container">
                    @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if(session()->has('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('warning')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <input type="text" wire:model="search" placeholder="Search product..." name="search" id="search" class="form-control">
                        </div>
                    </div>
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
                                <button type="button" class="btn btn-primary" wire:click="addToCart({{ $item->id }})">Add</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endforeach
                    </div>
                  </div>
            </div>
            {{-- Cart Section --}}
            <div class="col-md-4 mt-2">
                @if(session()->has('quantity'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('quantity') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h6 class="text-uppercase text-center">
                    <i class="bi bi-cart-fill"></i> Order Summary
                </h6>
                @foreach($order as $item)
                <div class="col-md p-3 text-uppercase">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <p class="card-text text-start fw-bold">{{ $item->product_name }}</p>
                            </div>
                            <div class="col">
                                <p class="card-text text-end badge bg-primary">₱{{ number_format($item->price,2) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <p class="card-text text-start">{{ $item->size}}</p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <p class="card-text text-start">TOTAL PRICE: </p>
                            </div>
                            <div class="col">
                                <p class="card-text text-end badge bg-primary">{{ $item->quantity }} x ₱{{ number_format($item->total_price,2) }}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                {{-- edit quantity --}}
                                <label for="quantity">Quantity:</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group mb-3 col-md-8">
                                            <button type="submit" name="decrement" value="1" wire:click.prevent="decrement({{ $item->id }})" class="btn btn-outline-secondary">-</button>

                                            <input type="number" id="quantity-{{ $item->id }}" min="1" value="{{ $item->quantity }}" wire:change="updateQuantity({{ $item->id }}, $event.target.value)" wire:model="quantity.{{ $item->id }}" class="form-control text-center" oninput="this.value = Math.max(this.value, 1)">

                                            <button type="submit" name="increment" wire:click.prevent="increment({{ $item->id }})" value="1" class="btn btn-outline-secondary">+</button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-danger" type="button" data-bs-target="#modal-delete{{ $item->id}}" data-bs-toggle="modal">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                @endforeach
                
                @if(!$order->isEmpty())
                    <button type="button" class="btn btn-primary float-end w-75" data-bs-toggle="modal" data-bs-target="#confirmCheckoutModal"> <i class="bi bi-check-circle-fill"></i> Confirm</button>
                @else
                    <div class="alert alert-info text-center" role="alert">
                        No items in the order.
                    </div>
                @endif


            </div>
        </div>
    </div>
    {{ $products->links() }}
</div>
