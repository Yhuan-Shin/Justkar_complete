<div wire:poll.3000ms class="container mt-4">
    <h5 class="mb-4">Notifications</h5>
    <div class="list-group" style="max-height: 400px; overflow-y: auto;">
        @foreach($stock_notifications as $notification)
            <div class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">Product Code: {{ $notification->inventory->product_code }}</h6>
                    <small>{{ $notification->created_at->setTimezone('Asia/Manila')->format('Y-m-d h:i:s A') }}</small>
                </div>
               
                 @if($notification->inventory->status == 'outofstock')
                    <p class="mb-1 badge bg-danger">Status: Out of Stock</p>
                @elseif($notification->inventory->status == 'lowstock')
                    <p class="mb-1 badge bg-warning">Status: Low Stock</p>
                @elseif($notification->inventory->status == 'instock')
                    <p class="mb-1 badge bg-success">Status: In Stock</p>
                @endif
            </div>
        @endforeach
        @if($stock_notifications->count() == 0)
            <div class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">No notifications</h6>
                </div>
            </div>
        @endif
    </div>
</div>
