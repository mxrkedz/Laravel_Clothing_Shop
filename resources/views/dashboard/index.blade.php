@extends('layouts.admindashboard')

@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Charts</h4>

        <!-- Supplier Demographics Chart -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                        <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                            <div class="card-title">
                                <h5 class="text-nowrap mb-2">Supplier Demographics</h5>
                                <span class="badge bg-label-warning rounded-pill">Year <script>document.write(new Date().getFullYear());</script></span>
                            </div>
                        </div>
                    </div>
                    @if (empty($supplierChart))
                        <div></div>
                    @else
                        <div>{!! $supplierChart->container() !!}</div>
                        {!! $supplierChart->script() !!}
                    @endif
                </div>
            </div>
        </div>

        <!-- Orders Demographics Chart -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                        <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                            <div class="card-title">
                                <h5 class="text-nowrap mb-2">Orders Demographics</h5>
                                <span class="badge bg-label-warning rounded-pill">Year <script>document.write(new Date().getFullYear());</script></span>
                            </div>
                        </div>
                    </div>
                    @if (empty($orderChart))
                        <div></div>
                    @else
                        <div>{!! $orderChart->container() !!}</div>
                        {!! $orderChart->script() !!}
                    @endif
                </div>
            </div>
        </div>

        <!-- Sales Chart -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                        <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                            <div class="card-title">
                                <h5 class="text-nowrap mb-2">Sales Chart</h5>
                                <span class="badge bg-label-warning rounded-pill">Year <script>document.write(new Date().getFullYear());</script></span>
                            </div>
                        </div>
                    </div>
                    @if (empty($salesChart))
                        <div></div>
                    @else
                        <div>{!! $salesChart->container() !!}</div>
                        {!! $salesChart->script() !!}
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Chart -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                        <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                            <div class="card-title">
                                <h5 class="text-nowrap mb-2">Product Chart</h5>
                                <span class="badge bg-label-warning rounded-pill">Year <script>document.write(new Date().getFullYear());</script></span>
                            </div>
                        </div>
                    </div>
                    @if (empty($itemChart))
                        <div></div>
                    @else
                        <div>{!! $itemChart->container() !!}</div>
                        {!! $itemChart->script() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection