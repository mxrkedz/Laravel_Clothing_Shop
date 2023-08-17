<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>TwentyO'2</title>

     <!-- Fonts -->
     <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSRF TOKEN -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon  -->
    <link rel="icon" href="{{ asset('dashboard/assets/userdashboard/img/core-img/brand1.png') }}   ">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/userdashboard/css/core-style.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/userdashboard/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/userdashboard/js/bootstrap.min.js') }}">


</head>

<body>
    <!-- ##### Header Area Start ##### -->
    <header class="header_area">
        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
            <!-- Classy Menu -->
            <nav class="classy-navbar" id="essenceNav">
                <!-- Logo -->
                <a class="nav-brand" href="/home"><img src="{{ asset('dashboard/assets/userdashboard/img/core-img/brand1.png') }}" style="width: auto; height: 70px;" alt=""></a>
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
                        <li><a href="/home">Home</a></li>
                        <li><a href='/home #categories' id="shopLink" class="scroll-link">Shop</a>
    <div class="dropdown" style="top: 60px; max-height: 400px; overflow-y: auto; margin-left: 25px;">
        <ul class="single-mega cn-col-4">
            <li><a href="/womens">Women's Collection</a></li>
            <li><a href="/mens">Men's Collection</a></li>
            <li><a href="/unisex">Unisex Collection</a></li>
        </ul>
    </div>
</li>

                            @auth
                            @if (Auth::user()->isAdmin)
                            <li><a href="{{ url('/admin') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Admin Dashboard</a></li>
                            @endif
                            @endauth
                            <!-- <li><a href="blog.html">Blog</a></li> -->
                            <li>
    @auth
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <li><button type="submit" class="dropdown-item"><i class="fa-solid fa-right-from-bracket"></i> Logout</button></li>
        </form>
    @else
    <form action="{{ route('login') }}">
            @csrf
    <li><button class="dropdown-item"><i class="fa-solid fa-right-from-bracket"></i> Login</button></li>
    </form>

    @endauth
</li>
                        </ul>
                    </div>
                    <!-- Nav End -->
                </div>
            </nav>

            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">
                <!-- Search Area -->
                <div class="search-area">
                <form action="{{ route('search') }}" method="get">
                        <input type="search" name="q" id="headerSearch" placeholder="Search">
                        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
                <!-- Cart Area -->
                <div class="cart-area">
                    <a href="/cart" id="essenceCartBtn"><img src="{{ asset('dashboard/assets/userdashboard/img/core-img/bag.svg') }}" alt=""><span id="cartItemCount">0</span></a>
                </div>
            </div>

        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    @yield('customerguestindex')

    <footer class="footer_area clearfix">
        <div class="container">
            <div class="row">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area d-flex mb-30">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <a href="/home"><img src="{{ asset('dashboard/assets/userdashboard/img/core-img/brand2.png') }}" style="width: auto; height: 30px;" alt=""></a>
                        </div>
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <ul>
                                <li><a href="shop.html">Shop</a></li>
                                
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area mb-30">
                        <ul class="footer_widget_menu">
                            <li><a href="#">Order Status</a></li>
                            <li><a href="#">Payment Options</a></li>
                            <li><a href="#">Shipping and Delivery</a></li>
                            <li><a href="#">Guides</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Use</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row align-items-end">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area">
                        <div class="footer_social_area">
                            <p>Find Us On</P>
                            <a href="https://www.facebook.com/twentyO2" data-toggle="tooltip" target="_blank" data-placement="top" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="https://www.instagram.com/twentyo2mnl/" data-toggle="tooltip" target="_blank" data-placement="top" title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>

<div class="row mt-5">
                <div class="col-md-12 text-center">
                    <p>
     &copy;<script>document.write(new Date().getFullYear());</script>, TwentyO'2. All rights reserved.
                    </p>
                </div>
                    </p>
                </div>
            </div>

        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->
@yield('cartscripts')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper js -->
    <script src="dashboard/assets/userdashboard/js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="dashboard/assets/userdashboard/js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="dashboard/assets/userdashboard/js/plugins.js"></script>
    <!-- Classy Nav js -->
    <script src="dashboard/assets/userdashboard/js/classy-nav.min.js"></script>
    <!-- Active js -->
    <script src="dashboard/assets/userdashboard/js/active.js"></script>

        <!-- custom js -->
        <script src="dashboard/assets/js/cart.js"></script>
        <script src="dashboard/assets/js/checkout.js"></script>

<script>
    $(document).ready(function() {
        // Add smooth scrolling to links with the class "scroll-link"
        $(".scroll-link").on('click', function(event) {
            if (this.hash !== "") {
                event.preventDefault();

                var hash = this.hash;
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 400, function(){
                    window.location.hash = hash;
                });
            }
        });
    });

    // Fetch the cart item count and update the cart icon
    $(document).ready(function () {
        fetchCartItemCount();

        function fetchCartItemCount() {
            $.ajax({
                url: "{{ route('cart.count') }}", // Replace with the actual route
                method: 'GET',
                success: function (response) {
                    $('#cartItemCount').text(response.count);
                }
            });
        }

        // You can call this function whenever you add/remove items to/from the cart to update the quantity
        // fetchCartItemCount();
    });
</script>
</html>