@extends('layouts.userhome')
@section('customerguestindex')
<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb_area bg-img" style="background-image: url({{ asset('dashboard/assets/userdashboard/img/bg-img/women2.jpg') }});">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Women's Collection</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
</div>
    <!-- ##### Breadcumb Area End ##### -->
    <div id="categories" class="top_catagory_area section-padding-80 clearfix">
        <div class="container">
            <div class="row justify-content-center" style="display: flex; flex-wrap: wrap;">
                @foreach($items as $item) 
                
                
                <!-- Single Product -->
                
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-product-wrapper">
                        <!-- Product Image -->
                        <div class="product-img">
                            <img src="{{ asset($item->img) }}" alt="">

                                <!-- Product Description -->
                                <div class="product-description">
                                    <span>{{$item->sup_name}}</span>
                                    <h6>{{$item->item_name}}</h6>
                                    <p class="product-price">₱{{$item->sellprice}}</p>

                                        <!-- Hover Content -->
                                        <div class="hover-content">
                                            <!-- Add to Cart -->
                                            <div class="add-to-cart-btn">
                                               <form method="POST" action="{{ route('addcart', ['id' => $item->item_id]) }}" style="">
                                                    @csrf
                                                    <button type="submit" class="btn essence-btn">
                                                      <i class="fas fa-cart-plus"></i> Add to Cart
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        
                                </div>
                            </div>
                        </div>
                        

</div>
@endforeach
</div>
</div>
</div>

@endsection