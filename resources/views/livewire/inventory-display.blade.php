<div wire:poll.3000ms>
    <!-- Delete Confirmation Modal -->

      @foreach($inventory as $item)
        <div class="modal fade" id="modal-delete{{ $item->id }}" wire:ignore tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this item?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('inventory.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      @endforeach

      {{-- brand actions --}}
    <div class="modal fade" id="brandActionsModal" wire:ignore tabindex="-1" aria-labelledby="brandActionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="brandActionsModalLabel">Brand Actions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Select an action for Brand:</p>
                    <!-- Buttons for Add and Edit Actions -->
                    <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#addBrandModal" data-bs-dismiss="modal">
                        <i class="bi bi-plus-circle"></i> Add Brand
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateBrandModal" data-bs-dismiss="modal">
                        <i class="bi bi-pencil-square"></i> Edit Brand
                    </button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBrandModal" data-bs-dismiss="modal">
                        <i class="bi bi-trash"></i> Delete Brand
                    </button>
                </div>
            </div>
        </div>
    </div>
    
        {{-- product type actions --}}
    <div class="modal fade" id="typeActionsModal" wire:ignore tabindex="-1" aria-labelledby="typeActionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="typeActionsModalLabel">Product Type Actions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Select an action for Product Type:</p>
                    <!-- Buttons for Add and Edit Actions -->
                    <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#addProductTypeModal" data-bs-dismiss="modal">
                        <i class="bi bi-plus-circle"></i> Add Type
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateProductTypeModal" data-bs-dismiss="modal">
                        <i class="bi bi-pencil-square"></i> Edit Type
                    </button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProductTypeModal" data-bs-dismiss="modal">
                        <i class="bi bi-trash"></i> Delete Type
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- category actions --}}
    <div class="modal fade" id="categoryActionsModal" wire:ignore tabindex="-1" aria-labelledby="categoryActionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryActionsModalLabel">Category Actions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Select an action for Category</p>
                    <!-- Buttons for Add and Edit Actions -->
                    <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#addCategoryModal" data-bs-dismiss="modal">
                        <i class="bi bi-plus-circle"></i> Add Category
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateCategoryModal" data-bs-dismiss="modal">
                        <i class="bi bi-pencil-square"></i> Edit Category
                    </button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal" data-bs-dismiss="modal">
                        <i class="bi bi-trash"></i> Delete Category
                    </button>
                </div>
            </div>
        </div>
    </div>
    
 
    <div class="container" style="padding: 0px; width: 100%;">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if($inventory->isEmpty() && $search)
            <div class="alert alert-warning mt-4" role="alert">
                No results found for "{{ $search }}".
            </div>
        @endif
        <div class="row">
            <div class="col-md-2">
                <input type="checkbox" class="form-check-input" wire:model="selectAll"> Select All
            </div>
            <div class="col-md mb-2">
                <input type="text" wire:model="search" placeholder="Search product..." name="search" id="search" class="form-control">
            </div>
            <div class="col-md">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inventoryAddModal">
                <i class="bi bi-plus-circle"></i> Add Product 
            </button>
            </div>
           
            <div class="col-md">
                    <button wire:click="archiveSelected" class="btn btn-warning">    
                        <i class="bi bi-archive"></i> Archive</button>
            </div>
            <div class="col-md-4">
                <form method="GET" class="col-md mb-3 float-end">
                    <select name="filter" wire:model="filter" class="form-select">
                        <option value="all">All</option>
                        <option value="instock">In Stock</option>
                        <option value="lowstock">Low Stock</option>
                        <option value="outofstock">Out of Stock</option>
                    </select>
                    
                </form>
            </div>
        </div>
      
        <div class="row" style="padding: 0px">
            <div class="col-md-12">
                <div class="table-responsive mt-3 border rounded p-2 shadow">
                    <!-- table -->
                    <table class="table table-striped table-hover">
                     <thead class="table-dark   ">
                       <tr class="text-center" style="white-space: nowrap;">
                         <th scope="col">Product Code</th>
                         <th scope="col">Product Name</th>
                         <th scope="col" ><a href="" data-bs-toggle="modal" data-bs-target="#typeActionsModal" class="text-decoration-none text-light border border-light border-2 rounded p-1">
                            Product Type</a></th>
                         <th scope="col"><a href="" data-bs-toggle="modal" data-bs-target="#categoryActionsModal" class="text-decoration-none text-light border border-light border-2 rounded p-1">Category</a></th>
                         <th scope="col">Quantity</th>
                         <th scope="col">Status</th>
                         <th scope="col"><a href="#" data-bs-toggle="modal" data-bs-target="#brandActionsModal" class="text-decoration-none text-light border border-light border-2 rounded p-1">
                            Brand
                        </a></th>
                         <th scope="col">Size</th>
                         <th scope="col">Price</th>
                         <th scope="col">Description</th>
                         <th scope="col">Image</th>
                         <th scope="col">Actions</th>
            
                       </tr>
                     </thead>
                     <tbody>
            
                         @if(isset($error))
                             <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                 {{ $error }}
                                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                             </div>
                         @endif
                         {{-- row --}}
                         <div wire:loading wire:target="filter" class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                         @forelse($inventory as $item)
                         <tr class="text-center" style="white-space: nowrap;">
                            
                             <th scope="row">
                                <input type="checkbox" class="form-check-input" wire:model="selectedItems" value="{{ $item->id }}"> {{ $item->product_code }}
                            </th>
                             <td class="text-uppercase" >{{ $item->product_name }}</td>
                             <td class="text-uppercase">{{ $item->product_type }}</td>
                             <td>{{ $item->category }}</td>
                           
                             <td>{{ $item->quantity }}</td>
                             <td>
                                 @if($item->status == 'outofstock')
                                     <span class="badge bg-danger">Out of Stock</span>
                                 @elseif($item->status == 'lowstock')
                                     <span class="badge bg-warning">Low Stock</span>
                                 @elseif($item->status == 'instock')
                                     <span class="badge bg-success">In Stock</span>
                                 @endif
                             </td>
                             <td class="text-uppercase">{{ $item->brand }}</td>
                             <td class="text-uppercase">{{ $item->size }}</td>
                            <td class="text-uppercase">&#8369;{{ number_format($item->price, 2) }}</td>
                             <td class="text-uppercase">{{ $item->description }}</td>
                             <td>@if($item->img)
                                <img src="{{ asset('storage/'.$item->img) }}"style="width: 50px; height: 50px;">
                                @else
                                No Image
                                @endif

                             </td>

                             <td style="white-space: nowrap">
                                 <div class="btn-group" role="group" aria-label="Basic example">
                                    {{-- inventory display component --}}
                                     <button class="btn btn-primary" type="button" wire:click="$dispatch('openModal', { id: {{ $item->id }} })"><i class="bi bi-pencil-square"></i></button>
                                     <button class="btn btn-danger" type="button" data-bs-target="#modal-delete{{ $item->id}}" data-bs-toggle="modal"><i class="bi bi-trash3-fill"></i></button>
                                 </div>
                                 </td>
                         </tr>
                         @empty
                         <tr>
                             <td colspan="9" class="text-center">No records found</td>
                         </tr>
                         @endforelse
                       
                      
                       </tbody>
                   </table>
                  
                   <div class="container">
                        <div class="row ">

                            <div class="col-md d-flex  justify-content-end">
                                <div class="btn-group " role="group" aria-label="Basic example">
                                    <a href="{{ route('inventory.archived')}}" class="btn btn-primary me-2"><i class="bi bi-binoculars-fill"></i> View Archived</a>

                                    <form action="{{ route('inventory.export')}}" method="GET">
                                        <button class="btn btn-success">
                                            <i class="bi bi-file-pdf-fill"></i> Export to Excel</button>
                                    </form>   
                                </div>   
                            </div>
                            {{-- <div class="col">
                                <a  href="{{ route('inventory.exportToExcel')}}" class="btn btn-outline-success">Export to Excel</a>
                            </div> --}}
                        
                        </div>
                        <div class="row mt-2">
                            <div class="col-md d-flex justify-content-start">
                                {{ $inventory->links() }}

                            </div>
                        </div>

                   </div>
                 <!--  end table -->
                 </div>
                </div>
            
            </div>
        </div>   
</div>

