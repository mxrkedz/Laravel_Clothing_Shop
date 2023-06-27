@extends('layouts.admindashboard')
<script src="{{ asset('dashboard/assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{ asset('dashboard/assets/vendor/libs/popper/popper.js')}}"></script>
@section('active_menu', 'dashboard')
@section('content')
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4">Dashboard</h4>
              <!-- <h4 class="fw-bold py-3 mb-4"> TwentyO'2 <span class="text-muted fw-light">Admin Dashboard /</span></h4> -->

              <!-- Examples -->
              <div class="row mb-5">
                  <div class="card h-100">
                    <img class="card-img-top" src="{{ asset('dashboard/assets/img/elements/twenty02.png')}}" alt="Card image cap" />
                    <div class="card-body">
                      <h5 class="card-title">TwentyO'2</h5>
                      <p class="card-text">
                        TwentyO'2 is a clothing brand originating from the Philippines that embodies the values of world peace and love in its product offerings. With a focus on spreading positivity and harmony, TwentyO'2 creates fashionable and trendy clothing items that reflect these principles. By infusing their designs with elements that evoke a sense of unity and compassion, the brand aims to inspire individuals to embrace the ideals of peace and love in their daily lives. Whether through their unique graphics, slogans, or symbols, TwentyO'2 seeks to make a statement and contribute to a more peaceful and loving world through the medium of fashion.
                      </p>
                      <a href="/home" class="btn btn-outline-primary">Website</a>
                    </div>
                  </div>
                </div>
                </div>
            </div>

@endsection