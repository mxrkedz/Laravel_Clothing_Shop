@extends('layouts.admindashboard')

<!-- For Dropdown -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- For Dropdown -->
@section('active_menu', 'category')
@section('active_menu', 'manage')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="fw-bold py-3 mb-4">Manage <span class="text-muted fw-light">/ Category</span></h4>
    <div class="card">
        <div class="card-body">   
          @if(Session::has('added'))
    <div class="container text-white rounded align-items-center float-end" style="background-color: #5cb85c; max-width: 175px;">
        <div class="container-body">
            <p class="container-text text-center">{{ Session::get('added') }}</p>
    </div>
</div>
@endif
@if(Session::has('updated'))
    <div class="container text-white rounded align-items-center float-end" style="background-color: #5cb85c; max-width: 175px;">
        <div class="container-body">
            <p class="container-text text-center">{{ Session::get('updated') }}</p>
    </div>
</div>
@endif
@if(Session::has('deleted'))
    <div class="container text-white rounded align-items-center float-end" style="background-color: #ff4545; max-width: 175px;">
        <div class="container-body">
            <p class="container-text text-center">{{ Session::get('deleted') }}</p>
    </div>
</div>
@endif

            <p><a href="{{route('stocks.create')}}" class="btn btn-primary btn-lg float-start" role="button" aria-disabled="true" style="text-align: right; margin-bottom: 20px;">Create New</a></p>
            <table class="table" width="auto">
                <thead width="flex">
                    <tr>
                      <th scope="col" class="font-weight-bold">Item ID</th>
                      <th scope="col" class="font-weight-bold">Quantity</th>
                      <th scope="col" class="font-weight-bold">Description</th>
                      <th scope="col" class="font-weight-bold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stocks as $stock)
                    <tr>
                        <td>{{$stock->item_id}}</td>
                        <td>{{$stock->quantity}}</td>
                        <td>{{$stock->created_at}}</td>
                        <td>{{$stock->updated_at}}</td>
                        <td>
                        <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 12px; padding: 4px 8px; background-color: #696cff; border-color: #696cff;">
        <i class="fas fa-ellipsis-v fa-lg"></i>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 100px;">
        <a class="dropdown-item" href="{{route('stocks.edit',$stock->item_id)}}"><i class="fas fa-edit fa-lg" style="color: #FFAE42;"></i> Edit</a>
        <form style="margin-bottom: 0;" action="{{route('stocks.destroy',$stock->item_id)}}" method="POST">
            @method('DELETE')
            @csrf
            <button type="submit" class="dropdown-item"><i class="fas fa-trash fa-lg" style="color: #ff0000;"></i> Delete</button>
        </form>
    </div>
</div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
