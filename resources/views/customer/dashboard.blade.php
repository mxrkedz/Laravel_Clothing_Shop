@extends('layouts.userhome')
@section('customerguestindex')

    <!-- ##### Welcome Area Start ##### -->
    
    <section class="welcome_area bg-img background-overlay" style="background-image: url({{ asset('dashboard/assets/userdashboard/img/bg-img/banner.webp') }});">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
            <div class="col-12">
    <div class="hero-content">
        <h2 style="text-align: center;">
            <a href="#categories" class="scroll-link">
                <img src="{{ asset('dashboard/assets/userdashboard/img/core-img/brand1.png') }}" style="width: auto; height: auto;" alt="">
            </a>
        </h2>
    </div>
</div>
            </div>
        </div>
    </section>
    <!-- ##### Welcome Area End ##### -->

    <!-- ##### Top Catagory Area Start ##### -->
    <div id="categories" class="top_catagory_area section-padding-80 clearfix">
        <div class="container" >
        <div class="section-heading text-center">
                        <h2>COLLECTION</h2>
                    </div>
            <div class="row justify-content-center">
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image: url({{ asset('dashboard/assets/userdashboard/img/bg-img/women.webp') }});">
                        <div class="catagory-content">
                            <a href="/womens">Womens</a>
                        </div>
                    </div>
                </div>
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image:url({{ asset('dashboard/assets/userdashboard/img/bg-img/men.webp') }});">
                        <div class="catagory-content">
                            <a href="/mens">Mens</a>
                        </div>
                    </div>
                </div>
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image: url({{ asset('dashboard/assets/userdashboard/img/bg-img/banner.webp') }});">
                        <div class="catagory-content">
                            <a href="/unisex">Unisex</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="top_catagory_area section-padding-80 clearfix" style="background-color: #f2f2f2;">
    <div class="container" >
            <div class="row" >
                <div class="col-12">
                    <div class="section-heading text-center" >
                        <h2>SHOP FASHION FOR MEN AND WOMEN ONLINE ON TWENTY'O2</h2><br>
                        <h7>A truly exceptional brand hailing from the Philippines, TwentyO'2 represents a unique fusion of fashion and ideals. At the core of its offerings lies a profound commitment to world peace and love. By infusing its products with elements that radiate positivity and harmony, TwentyO'2 crafts stylish and contemporary clothing items that embody these principles. With every design, TwentyO'2 strives to inspire individuals to embrace the ideals of peace and love in their everyday lives.<br>
                        <br>The brand's designs are rich with symbolism, expressing unity and compassion through striking graphics, thought-provoking slogans, and meaningful motifs. TwentyO'2 doesn't just create fashion; it crafts statements that resonate with those who believe in a better, more peaceful world. Each piece serves as a testament to the power of clothing as a medium for spreading positive messages and fostering a sense of togetherness.
                            <br><br>In a world where fashion and ideals intersect, TwentyO'2 stands as a beacon of hope and positivity, inviting all to wear their values and make a meaningful impact. By donning TwentyO'2's creations, you become a part of a movement that envisions a brighter future, one where fashion becomes a force for change, a conduit for harmony, and a celebration of the universal principles of peace and love.
                        </h7>
                    </div>
                </div>
            </div>
        </div>
        </div>
    <!-- ##### Top Catagory Area End ##### -->
@endsection
 
@auth
@if (Auth::user()->isUser)  

<a class="menu-link logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span class="ms-auto">Logout</span>
        <i class="fa-solid fa-right-from-bracket" style="margin-left: 5px;"></i>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @endif
@endauth


