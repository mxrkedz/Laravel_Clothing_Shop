@extends('layouts.userhome')
@section('customerguestindex')

    <!-- ##### Welcome Area Start ##### -->
    
    <section class="welcome_area bg-img background-overlay" style="">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="hero-content">
                        <h3 style="color: white; text-shadow: 2px 2px 4px #666666;">Welcome To</h3>
                        <h2 style="color: white; text-shadow: 2px 2px 4px #666666;">PixelCoin</h2>
                        <a onclick="location.href='#categories'" class="btn essence-btn">View Categories</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Welcome Area End ##### -->

    <!-- ##### Top Catagory Area Start ##### -->
    <div id="categories" class="top_catagory_area section-padding-80 clearfix">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image: url({{ asset('dashboard/assets/userdashboard/img/bg-img/valorantlogo.jpg') }});">
                        <div class="catagory-content">
                            <a href="valorant">Valorant</a>
                        </div>
                    </div>
                </div>
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image:url({{ asset('dashboard/assets/userdashboard/img/bg-img/lollogo.webp') }});">
                        <div class="catagory-content">
                            <a href="leagueoflegends">League of Legends</a>
                        </div>
                    </div>
                </div>
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image: url({{ asset('dashboard/assets/userdashboard/img/bg-img/lorlogo.webp') }});">
                        <div class="catagory-content">
                            <a href="runeterra">Runeterra</a>
                        </div>
                    </div>
                </div>
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4" style="margin-top: 30px;">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image:url({{ asset('dashboard/assets/userdashboard/img/bg-img/tftlogo.png') }});">
                        <div class="catagory-content">
                            <a href="tft">Teamfight Tactics</a>
                        </div>
                    </div>
                </div>
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4" style="margin-top: 30px;">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image: url({{ asset('dashboard/assets/userdashboard/img/bg-img/lolwrlogo.png') }});">
                        <div class="catagory-content">
                            <a href="wildrift">LoL: WildRift</a>
                        </div>
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