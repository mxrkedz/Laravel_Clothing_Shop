@extends('layouts.admindashboard')
@section('content')
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="col-12 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                              <div class="card-title">
                                <h5 class="text-nowrap mb-2">Supplier Demographics</h5>
                                <span class="badge bg-label-warning rounded-pill">Year <script>document.write(new Date().getFullYear());</script></span>
                              </div>
                              <div class="mt-sm-auto">
                              </div>@if (empty($supplierChart))
                    <div></div>
                @else
                    <div>{!! $supplierChart->container() !!}</div>
                    {!! $supplierChart->script() !!}
                @endif
                            </div>
                          </div>
                        </div>

                        
                      </div>

                      
                    </div>

                    <div class="card">
                        <div class="card-body">
                          <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                              <div class="card-title">
                                <h5 class="text-nowrap mb-2">Supplier Demographics</h5>
                                <span class="badge bg-label-warning rounded-pill">Year <script>document.write(new Date().getFullYear());</script></span>
                              </div>
                              <div class="mt-sm-auto">
                              </div>@if (empty($townChart))
                    <div></div>
                @else
                    <div>{!! $townChart->container() !!}</div>
                    {!! $townChart->script() !!}
                @endif
                            </div>
                          </div>
                        </div>
                  </div>
                </div>
              </div>
              </div>
              </div>

        <div class="row">
            <div class="col-sm-6 col-md-6">
                <h2>Sales Chart</h2>


                @if (empty($salesChart))
                    <div></div>
                @else
                    <div>{!! $salesChart->container() !!}</div>
                    {!! $salesChart->script() !!}
                @endif
            </div>


            <div class="col-sm-6 col-md-6">
                <h2>Product Chart</h2>


                @if (empty($itemChart))
                    <div></div>
                @else
                    <div>{!! $itemChart->container() !!}</div>
                    {!! $itemChart->script() !!}
                @endif
            </div>
        </div>
    </div>
    @endsection