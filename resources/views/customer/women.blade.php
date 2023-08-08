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

    <!-- ##### Breadcumb Area End ##### -->
    <div id="categories" class="top_catagory_area section-padding-80 clearfix">
        <div class="container">
            <div class="row justify-content-center" style="display: flex; flex-wrap: wrap;">
                @foreach($items as $item) 
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area  bg-img" style="margin-bottom: 30px; background-image: url({{ asset('dashboard/assets/userdashboard/img/bg-img/blog5.jpg') }});">
                  
                    <div class="cart-item-desc">
                    <form method="POST" action="{{ route('addcart', ['id' => $item->item_id]) }}" style="width: 30px; position: absolute; text-align: absolute; bottom: 10px; right: 120px;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-cart-plus"></i> Add to Cart
                                    </button>
                                </form>

                            <h2 style="position: absolute; top: 10px; left:10px;">{{$item->item_name}}</h6><br><br>
                            <h3 style="color: green; position: absolute; top: 50px; left:10px;">${{$item->sellprice}}</h3>
                        </div>
                </div>
                </div>
                @endforeach
</div>
</div>
</div>

@endsection