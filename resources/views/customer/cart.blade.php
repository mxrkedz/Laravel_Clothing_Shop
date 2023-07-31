@extends('layouts.userhome')
@section('customerguestindex')
<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb_area bg-img" style="background-image: url({{ asset('dashboard/assets/userdashboard/img/bg-img/breadcumb.jpg') }});">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2><img src="{{ asset('dashboard/assets/userdashboard/img/core-img/bag.svg') }}" alt="" style="width: 3%; margin-top: -15px;";> Cart</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- ##### Breadcumb Area End ##### -->

            <!-- Cart Summary -->
            <!-- <div class="col-12 ">
                

                    <div class="order-details-confirmation" style="margin-top: 50px">
                        <ul class="order-details-form mb-4">


            <div class="cart-page-heading">

          <label for="username">Username (In-Game)</label>
          
          <input type="text" class="form-control" id="username" placeholder="Enter In-Game" name="username">
        </div>
        </div>

</div> -->
            <div class="col-12 ">
                

                    <div class="w-100 order-details-confirmation" style="margin-top: 50px">
                    
                        <div class="cart-page-heading">
                            <h5>Review Order Details</h5>
                            <!-- <p>The Details</p> -->
                        </div>

                        <ul class="order-details-form mb-4">
                          
                            <li><span><u>Product Image</u></span><span><u>Product</u></span> <span><u>Price</u></span> <span><u>Action</u></span></li>
                            @foreach($cart as $carts)
                            <li><span><img src="{{asset($carts->img_path)}}" alt="" width="100px" height="100px"></span><span>{{$carts->item_name}}</span> <span style="display: flex;
  flex-direction: column;
  align-items: center;
  list-style: none;
  padding: 0;">${{$carts->sell_price}}</span> 
                                   <td class="btn-group">
                                   <span>
  <div style="display: inline-block; padding: 5px; margin-right: 5px;">
    <a href="{{ route('decrement', ['id' => $carts->product_id]) }}" style="color: blue;"><i class="fa-solid fa-minus"></i></a>
    <a style="display: inline-block; width: 20px; height: 20px; border: 2px solid black; text-align: center; line-height: 15px; margin: 0px 5px;">{{$carts->quantity}}</a>
    <a href="{{ route('increment', ['id' => $carts->product_id]) }}" style="color: blue;"><i class="fa-solid fa-plus"></i></a>
  </div>
  <div style="display: inline-block; padding: 5px;">
    <a href="{{ route('deletecart', ['id' => $carts->product_id]) }}" style="color: red;"><i class="fa-solid fa-trash" style="font-size:16px;"></i></a>
  </div>
</span>


</td>
</li>
                            @endforeach
                            <li><span>Total</span> <span></span> <span>${{$totalprice}}</span> <span></span></li>
                        </ul>
                        <form id="myform" method="POST" action="{{ route('checkout', ['id' => $user]) }}">
    @csrf
    <div id="accordion" role="tablist" class="mb-4">
        <div class="card">
            <div class="card-header" role="tab" id="headingOne">
                <h6 class="mb-0">
                    <select name="payment_id" id="payment_id">
                        <option selected disabled>Select Payment Method</option>
                        @foreach($payment as $pay)
                        <option value={{$pay->id}}>{{$pay->name}}</option>
                        @endforeach
                    </select>
                </h6>
            </div>
        </div>
    </div>
    <button type="submit" class="btn essence-btn" id="checkout-button"><i class="fas fa-cart-plus"></i> Checkout</button>
</form>

<script>
    var paymentSelect = document.getElementById('payment_id');
    var checkoutButton = document.getElementById('checkout-button');

    paymentSelect.addEventListener('change', function() {
        if (!paymentSelect.value || paymentSelect.value === 'Select Payment Method') {
            checkoutButton.disabled = true;
        } else {
            checkoutButton.disabled = false;
        }
    });
</script>



                                
                                

                    </div>
                </div>

                <style>
		#popup {
			display: none;
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			background-color: #fff;
			padding: 20px;
			border: 1px solid #ccc;
			box-shadow: 0px 0px 10px #ccc;
			z-index: 9999;
			max-width: 150%;
			max-height: 90%;
			overflow-y: auto;
		}
        .popup-overlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
			z-index: 9998;
		}
	</style>

<script>
		var popup = document.getElementById("popup");

		function showPopup() {
			popup.style.display = "block";
		}

		function hidePopup() {
			popup.style.display = "none";
		}
	</script>
</head>
            
@endsection