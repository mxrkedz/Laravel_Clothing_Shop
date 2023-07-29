<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>PixelCoin</title>

     <!-- Fonts -->
     <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Favicon  -->
    <link rel="icon" href="{{ asset('dashboard/assets/userdashboard/img/core-img/pixelcoin.png') }}   ">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/userdashboard/css/core-style.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/userdashboard/css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- ##### Header Area Start ##### -->
    <header class="header_area">
        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
            <!-- Classy Menu -->
            <nav class="classy-navbar" id="essenceNav">
                <!-- Logo -->
                <a class="nav-brand" href="homepage"><img src="{{ asset('dashboard/assets/userdashboard/img/core-img/pixelcoin.png') }}" style="width: auto; height: 70px;" alt=""></a>
                <!-- Navbar Toggler -->
                <div class="classy-navbar-toggler">
                    <span class="navbarToggler"><span></span><span></span><span></span></span>
                </div>
                <!-- Menu -->
                <div class="classy-menu">
                    <!-- close btn -->
                    <div class="classycloseIcon">
                        <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                    </div>
                    <!-- Nav Start -->
                    <div class="classynav" style="position: relative;">
                        <ul>
                        <li><a href="/homepage">Home</a></li>
                            <li><a href='/homepage#categories'>Shop</a>
                                <div class="dropdown" style="top: 60px">
                                    <ul class="single-mega cn-col-4">
                                        <li class="title" style="text-align: center; color: red; font-weight: bold;">Riot Games</li>
                                        <li><a href="/valorant">Valorant</a></li>
                                        <li><a href="/leagueoflegends">League of Legends</a></li>
                                        <li><a href="/runeterra">Runeterra</a></li>
                                        <li><a href="/tft">Teamfight Tactics</a></li>
                                        <li><a href="/wildrift">LoL: WildRift</a></li>

                                    </ul>
                                    <div class="single-mega cn-col-4">
                                        <img src="img/bg-img/bg-6.jpg" alt="">
                                    </div>
                                </div>
                            </li>
                            @auth
                            @if (Auth::user()->isAdmin)
                            <li><a href="{{ url('/admin') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Admin Dashboard</a></li>
                            @endif
                            @endauth
                            <!-- <li><a href="blog.html">Blog</a></li> -->
                            <li><form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="dropdown-item"><i class="fa-solid fa-right-from-bracket"></i></button>
</form></li>
                        </ul>
                    </div>
                    <!-- Nav End -->
                </div>
            </nav>

            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">
                <!-- Search Area -->
                <div class="search-area">
                <form action="#" method="get">
                        <input type="search" name="search" id="headerSearch" placeholder="Search">
                        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
                <!-- User Login Info -->
                <div class="user-login-info">
                    <a style="display:flex;justify-content:center;"><img src="{{ asset('dashboard/assets/userdashboard/img/core-img/user.svg') }}" alt=""></a>
                </div>
                <!-- Cart Area -->
                <div class="cart-area">
                    <a href="" id="essenceCartBtn" style="display:flex;justify-content:center;"><img src="{{ asset('dashboard/assets/userdashboard/img/core-img/bag.svg') }}" alt=""></a>
                </div>
            </div>

        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    @yield('customerguestindex')
    <!-- ##### Footer Area Start ##### -->
    <footer class="footer_area clearfix">
                <div class="col-md-12 text-center">
                    <p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved 
    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
    </footer>
    <!-- ##### Footer Area End ##### -->

    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="js/plugins.js"></script>
    <!-- Classy Nav js -->
    <script src="js/classy-nav.min.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>

</body>

</html>