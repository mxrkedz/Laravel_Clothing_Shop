@extends('layouts.userhome')

@section('customerguestindex')
<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb_area bg-img" style="background-image: url({{ asset('dashboard/assets/userdashboard/img/bg-img/breadcumb.jpg') }});">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2><img src="{{ asset('dashboard/assets/userdashboard/img/core-img/bag.svg') }}" alt="" style="width: 3%; margin-top: -15px;"> Cart</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- ##### Breadcumb Area End ##### --><br>
    <div class="container">
    <div class="card shadow">
        <div class="card-body">
            @php $total = 0; @endphp
            @if($cartItems->isEmpty())
                <p>Your Cart is Empty</p>
                <a href="/"class="btn btn-outline-success float-end">Continue Shopping</a>
            @else
            <div class="row item_data" style="border-bottom: 1px solid #e0e0e0; padding-bottom: 10px; margin-bottom: 10px;">
                <div class="col-md-2 my-auto">
                    <h6></h6>
                </div>
                <div class="col-md-3 my-auto">
                    <h6>Product Name</h6>
                </div>
                <div class="col-md-2 my-auto">
                    <h6>Price</h6>
                </div>
                <div class="col-md-2 my-auto">
                    <h6>Subtotal</h6>
                </div>
                <div class="col-md-3 my-auto">
                    <h6>Quantity</h6>
                </div>
                <div class="col-md-2 my-auto">
                    <h6></h6>
                </div>
            </div>
            @foreach($cartItems as $item)
            <div class="row item_data" style="border-bottom: 1px solid #e0e0e0; padding-bottom: 10px; margin-bottom: 10px;">
                <div class="col-md-2 my-auto">
                    <img src="{{ asset($item->items->img_path) }}" height="70px" width="auto" alt="Image here" style="margin-bottom: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);">
                </div>
                <div class="col-md-3 my-auto">
                    <span>{{ $item->items->item_name}}</span>
                </div>
                <div class="col-md-2 my-auto">
                    <span>₱ {{ number_format($item->items->sellprice, 2) }}</span>
                </div>
                <div class="col-md-2 my-auto">
                    <span>₱ {{ number_format($item->items->sellprice * $item->quantity, 2) }}</span>
                </div>
                <div class="col-md-3 my-auto">
                    <input type="hidden" class="item_id" value="{{ $item->item_id }}">
                    <div class="input-group text-center mb-3" style="width:130px;">
                        <button class="input-group-text changeQuantity decrement-btn">-</button>
                        <input type="text" name="quantity" class="form-control qty-input text-center" value="{{ $item->quantity }}">
                        <button class="input-group-text changeQuantity increment-btn">+</button>
                    </div>
                </div>
                <div class="col-md-2 my-auto">
                    <button class="btn btn-danger delete-cart-item"><i class="fa fa-trash"></i> Remove</button>
                </div>
            </div>
            @php $total += $item->items->sellprice * $item->quantity; @endphp

            @endforeach
        </div>
        <div class="card-footer">
            <h5>Total Price : <p>₱ {{ number_format($total, 2) }}</p>
            </h5>
            <a href="/checkout"class="btn btn-outline-success float-end">Proceed to Checkout</a>
            @endif
        </div>
        
    </div>
</div>
<br>
@endsection
