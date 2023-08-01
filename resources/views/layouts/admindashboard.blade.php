<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('dashboard/assets/')}}"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Clothing Shop</title>

    <meta name="description" content="" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('dashboard/assets/img/elements/mxrkedzLogo.png') }}" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/fonts/boxicons.css') }}" />
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/demo.css') }}" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <!-- Helpers -->
<script src="{{ asset('dashboard/assets/vendor/js/helpers.js') }}"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ asset('dashboard/assets/js/config.js') }}"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="/admin" class="app-brand-link">
            <img class="app-brand-logo demo" src="{{ asset('dashboard/assets/img/elements/twenty02.png') }}" alt="Logo" style="width: 100%; height: auto;">
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item @if(isset($active_menu) && $active_menu == 'dashboard') active @endif">
              <a href="/admin" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="/home" class="menu-link">
                <i class="menu-icon tf-icons bx bx-globe"></i>
                <div data-i18n="Website">Open Site</div>
              </a>
            </li>
            <!-- Manage -->
            <li class="menu-item parent-menu">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-edit-alt"></i>
                <div data-i18n="Manage">Manage</div> <!-- CRUD -->
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="/category" class="menu-link @if(isset($active_menu) && $active_menu == 'category') active @endif">
                    <div data-i18n="Category">Category</div>
                  </a>
                </li>
              </ul>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="/paymentmethods" class="menu-link @if(isset($active_menu) && $active_menu == 'paymenthmethod') active @endif">
                    <div data-i18n="Payment Method">Payment Method</div>
                  </a>
                </li>
              </ul>
              <!-- Manage DataTables-->
            <li class="menu-item parent-menu">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="DataTable">Data Tables</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="/categories/datatables" class="menu-link @if(isset($active_menu) && $active_menu == 'categories') active @endif">
                    <div data-i18n="categories">Categories</div>
                  </a>
                </li>
              </ul>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="/customers" class="menu-link @if(isset($active_menu) && $active_menu == 'customers') active @endif">
                    <div data-i18n="customers">Customers</div>
                  </a>
                </li>
              </ul>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="/items" class="menu-link @if(isset($active_menu) && $active_menu == 'items') active @endif">
                    <div data-i18n="items">Items</div>
                  </a>
                </li>
              </ul>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="/shipping" class="menu-link @if(isset($active_menu) && $active_menu == 'shipping') active @endif">
                    <div data-i18n="shipping">Shipping</div>
                  </a>
                </li>
              </ul>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="/suppliers" class="menu-link @if(isset($active_menu) && $active_menu == 'suppliers') active @endif">
                    <div data-i18n="suppliers">Suppliers</div>
                  </a>
                </li>
              </ul>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="/paymentmethods/datatables" class="menu-link @if(isset($active_menu) && $active_menu == 'paymentmethods') active @endif">
                    <div data-i18n="paymentmethods">Payment Methods</div>
                  </a>
                </li>
              </ul>
              <!--Logout-->
              <li class="menu-item parent-menu">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-user"></i>
                <div data-i18n="Profile">Profile</div>
              </a>
              <ul class="menu-sub">
              <li class="menu-item">
    <a class="menu-link logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span class="ms-auto">Logout</span>
        <i class="fa-solid fa-right-from-bracket" style="margin-left: 5px;"></i>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>
              </ul>
<style>
    .menu-item:hover .menu-link.logout {
        color: red;
    }

    .menu-item:hover .menu-link.logout i {
        color: red;
    }
</style>


              <!---->


            </li>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">

          <!-- Content wrapper -->
          <div class="content-wrapper">
            @yield('content')
            </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('dashboard/assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset('dashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    <script src="{{ asset('dashboard/assets/vendor/js/menu.js')}}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('dashboard/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

    <!-- Main JS -->
    <script src="{{ asset('dashboard/assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{ asset('dashboard/assets/js/dashboards-analytics.js')}}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
    $(document).ready(function() {
        // Get the current page URL
        var currentUrl = window.location.href;

        // Check each menu item's URL and add the 'active' class if it matches the current URL
        $('.menu-link').each(function() {
            var menuUrl = $(this).attr('href');
            if (currentUrl.includes(menuUrl)) {
                $(this).closest('.menu-item').addClass('active');
            }
        });

        // Check if the current URL is within the submenu and add the 'active' class to both the parent menu item and the submenu item
        $('.menu-sub .menu-link').each(function() {
            var submenuUrl = $(this).attr('href');
            if (currentUrl.includes(submenuUrl)) {
                $(this).closest('.menu-item').addClass('active open');
                $(this).closest('.menu-item.parent-menu').addClass('active open');
            }
        });
    });
</script>
@include('layouts.scripts')
  </body>
</html>
