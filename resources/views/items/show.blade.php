@extends('layouts.userhome')
@section('customerguestindex')
<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb_area bg-img" style="background-image: url({{ asset('dashboard/assets/userdashboard/img/bg-img/breadcumb.jpg') }});">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Search Result</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- ##### Breadcumb Area End ##### -->
    <div id="categories" class="top_catagory_area section-padding-80 clearfix">
        <div class="container">
            <div class="row justify-content-center" style="display: flex; flex-wrap: wrap;">
            @if($items->count())
            @foreach($items as $item) 
                
                
                <!-- Single Product -->
                
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-product-wrapper item_data">
                        <!-- Product Image -->
                        <div class="product-img">
                            <img src="{{ asset($item->img) }}" alt="">

                                <!-- Product Description -->
                                <div class="product-description">
                                    <span>{{$item->sup_name}}</span>
                                    <!-- <span>{{$item->item_id}}</span> -->
                                    <h6>{{$item->item_name}}</h6>
                                    <p class="product-price">₱{{$item->sellprice}}</p>

                                        <!-- Hover Content -->
                                        <div class="hover-content">
                                            <!-- Add to Cart -->
                                            <div class="add-to-cart-btn">
                                                <input type="hidden" name="quantity" class="form-control qty-input" value="1">
                                                <input type="hidden" class="item_id" value="{{ $item->item_id }}">
                                                    <button type="submit" class="btn essence-btn addToCartBtn">
                                                      <i class="fas fa-cart-plus"></i> Add to Cart
                                                    </button>
                                            </div>
                                        </div>
                                        
                                </div>
                            </div>
                        </div>
                        

</div>
@endforeach
                @else
                    <p>No results found.</p>
                @endif
</div>
</div>
</div>

@endsection