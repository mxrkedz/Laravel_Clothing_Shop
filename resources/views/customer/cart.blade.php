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
    <!-- ##### Breadcumb Area End ##### -->
<br>
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
</div>
 <!-- Cart Summary -->
 <div class="col-12 ">

<div class="w-100 order-details-confirmation" style="margin-top: 50px">
@if(session('cart') && count(session('cart')) > 0)
    <div class="cart-page-heading">
        <h5>Review Order Details</h5>
        <!-- <p>The Details</p> -->
    </div>

<table id="cart" class="table table-hover table-condensed">
    <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%" >Action</th>
        </tr>
    </thead>
<tbody>
        @php $total = 0 @endphp
        @if(session('cart'))
            @foreach(session('cart') as $id => $details)
                @php $total += $details['price'] * $details['quantity'] @endphp
                <tr data-id="{{ $id }}">
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs"><img src="{{ asset($details['img_path']) }}" width="100" height="100" class="img-responsive"/></div>
                            <div class="col-sm-9">
                                <h6 class="">{{ $details['item_name'] }}</h6>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">₱{{ $details['price'] }}</td>
                    <td data-th="Quantity">
                        <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity cart_update" min="1" />
                    </td>
                    <td data-th="Subtotal" class="text-center">${{ $details['price'] * $details['quantity'] }}</td>
                    <td class="actions" data-th="">
                        <button class="btn btn-danger btn-sm cart_remove"><i class="fa fa-trash-o"></i> Delete</button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right"><h5>Total: ₱{{ $total }}</h5></td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">
                <a href="{{ url('/') }}" class="btn btn-danger"> <i class="fa fa-arrow-left"></i> Continue Shopping</a>
                <button class="btn btn-success"><i class="fa fa-money"></i> Checkout</button>
            </td>
        </tr>
    </tfoot>
</table>
@else
<div class="text-center">
        <h5>Your cart is empty.</h5>
        <a href="{{ url('/') }}" class="btn btn-success"> <i class="fa fa-arrow-left"></i> Continue Shopping</a>
    </div>
@endif
</div>
</div>
<br>
@endsection
@section('cartscripts')
<script type="text/javascript">
   $(".cart_update").change(function (e) {
        e.preventDefault();
   
        var ele = $(this);
   
        $.ajax({
            url: '{{ route('update_cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}', 
                id: ele.parents("tr").attr("data-id"), 
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });
    $(".cart_remove").click(function (e) {
        e.preventDefault();
   
        var ele = $(this);
   
        if(confirm("Do you really want to remove?")) {
            $.ajax({
                url: '{{ route('remove_from_cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
   
</script>
@endsection