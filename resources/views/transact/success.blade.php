@extends('layouts.userhome')

@section('customerguestindex')
    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb_area bg-img" style="background-size: cover; background-image: url({{ asset('dashboard/assets/userdashboard/img/bg-img/banner.webp') }});">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Order Successful!</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->
    
    <!-- Add any additional content or messages here -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <div style="padding: 200px;">
                    <p>Your order has been placed successfully. Thank you for shopping with us!</p>
                    <p>You will receive an email confirmation shortly.</p>
                    <a href="/" class="btn btn-primary mt-3">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
@endsection
