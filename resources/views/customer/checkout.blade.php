@extends('layouts.userhome')
@section('customerguestindex')
    <!-- Your checkout page content goes here -->

    <!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb_area bg-img" style="background-image: url({{ asset('dashboard/assets/userdashboard/img/bg-img/breadcumb.jpg') }});">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2><img src="{{ asset('dashboard/assets/userdashboard/img/core-img/bag.svg') }}" alt="" style="width: 3%; margin-top: -15px;"> Checkout</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Checkout Area Start ##### -->
    <form action="{{ url('place-order') }}" method="POST" id="checkout-form">
        @csrf
    <div class="checkout_area section-padding-80">
        <div class="container">
            <div class="row">

                <div class="col-12 col-md-6">
                    <div class="checkout_details_area mt-50 clearfix">

                        <div class="cart-page-heading mb-30">
                            <h5>Billing Address</h5>
                        </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name">First Name <span>*</span></label>
                                    <input type="text" class="form-control" name="fname" id="first_name" value="{{ Auth::user()->name}}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name">Last Name <span>*</span></label>
                                    <input type="text" class="form-control" name="lname" id="last_name" value="{{ Auth::user()->lname}}" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="country">Country <span>*</span></label>
                                    <input type="text" class="form-control" name="country" id="last_name" value="{{ Auth::user()->country}}" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="street_address">Address 1 <span>*</span></label>
                                    <input type="text" class="form-control mb-3" name="address1" id="street_address" value="{{ Auth::user()->address1}}">
                                    <label for="street_address">Address 2 <span>*</span></label>
                                    <input type="text" class="form-control" name="address2" id="street_address2" value="{{ Auth::user()->address2}}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="postcode">Postcode <span>*</span></label>
                                    <input type="text" class="form-control" name="postcode" id="postcode" value="{{ Auth::user()->postcode}}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="city">Town/City <span>*</span></label>
                                    <input type="text" class="form-control" name="city" id="city" value="{{ Auth::user()->city}}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="state">Province <span>*</span></label>
                                    <input type="text" class="form-control" name="province" id="state" value="{{ Auth::user()->province}}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="phone_number">Phone No <span>*</span></label>
                                    <input type="text" class="form-control" name="phone" id="phone_number" value="{{ Auth::user()->phone}}">
                                </div>
                                <div class="col-12 mb-4">
                                    <label for="email_address">Email Address <span>*</span></label>
                                    <input type="email" class="form-control" name="email" id="email_address" value="{{ Auth::user()->email}}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-5 ml-lg-auto">
                    <div class="order-details-confirmation">

                        <div class="cart-page-heading">
                            <h5>Order Summary</h5>
                        </div>

                        <ul class="order-details-form mb-4">
    <li><span>Product</span> <span>Subtotal</span></li>
    @php $total = 0; @endphp
    @foreach ($cartitems as $item)
        @php $subtotal = $item->items->sellprice * $item->quantity; @endphp
        <li><span>{{$item->items->item_name}} x ({{$item->quantity}})</span> <span>₱ {{ number_format($subtotal, 2) }}</span></li>
        @php $total += $subtotal; @endphp
    @endforeach
    <li><span>Total</span> <span>₱ {{ number_format($total, 2) }}</span></li>
</ul>


                        <div id="accordion" role="tablist" class="mb-4">
                            <div class="card">
                            <h6>Payment Method</h6>
<div class="row">
    <select class="form-select form-control" name="pmethod_id" id="pmethod_id">
        <option selected>Select Payment Method</option>
        @foreach ($paymentMethods as $pm)
            <option value="{{ $pm->id }}">{{ $pm->methods }}</option>
        @endforeach
    </select>
</div>
<br>
<h6>Shipping Via</h6>
<div class="row">
    <select class="form-select form-control" name="shipper_id" id="shipper_id">
        <option selected>Select Shipper</option>
        @foreach ($shipper as $ship)
            <option value="{{ $ship->id }}">{{ $ship->ship_name }}</option>
        @endforeach
    </select>
</div>



                            </div>
                        </div>

                        <button type="submit" id="checkout-button" class="btn essence-btn">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

    <!-- ##### Checkout Area End ##### -->
@endsection
