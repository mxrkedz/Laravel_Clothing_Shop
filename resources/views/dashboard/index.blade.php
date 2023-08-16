@extends('layouts.admindashboard')
@section('content')
    <div class="container">
       
        <div class="row">


            <div class="col-sm-6 col-md-6">
                <h2>Supplier Demographics</h2>


                @if (empty($supplierChart))
                    <div></div>
                @else
                    <div>{!! $supplierChart->container() !!}</div>
                    {!! $supplierChart->script() !!}
                @endif
            </div>


             <div class="col-sm-6 col-md-6">
                <h2>TownDemographics</h2>


                @if (empty($townChart))
                    <div></div>
                @else
                    <div>{!! $townChart->container() !!}</div>
                    {!! $townChart->script() !!}
                @endif
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