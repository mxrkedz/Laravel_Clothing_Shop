@extends('layouts.admindashboard')

<!-- For Dropdown -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- For Dropdown -->
@section('active_menu', 'item')
@section('active_menu', 'manage')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="fw-bold py-3 mb-4">Manage <span class="text-muted fw-light">/ Item</span></h4>
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
<div class="row">
        <div class="col-12 table-responsive">
            <div align="left"><a href="{{route('items.create')}}" class="btn btn-primary btn-lg float-start" role="button" aria-disabled="true" style="margin-right: 15px;">Create New</a>
            <a href="{{url('items/export')}}" name="excel" id="excel" class="btn btn-outline-secondary" style="margin-top: 6px;"><span class="tf-icons bx bx-grid"></span> Export Excel</a>
</div>
<br>
        <form action="{{url('items/import')}}" method="post" enctype="multipart/form-data">
                       @csrf
                       <fieldset>
                           <label>Select File to Upload  <small class="warning text-muted">{{__('Please upload only Excel (.xlsx or .xls) files')}}</small></label>
                           <div class="input-group">
                               <input type="file" required class="form-control" name="uploaded_file" id="uploaded_file">
                               @if ($errors->has('uploaded_file'))
                                   <p class="text-right mb-0">
                                       <small class="danger text-muted" id="file-error">{{ $errors->first('uploaded_file') }}</small>
                                   </p>
                               @endif
                               <div class="input-group-append" id="button-addon2">
                                   <button class="btn btn-primary square" type="submit"><i class="ft-upload mr-1"></i> Upload</button>
                               </div>
                           </div>
                       </fieldset>
                   </form>            <table class="table" width="auto">
                <thead width="flex">
                    <tr>
                    <th scope="col" class="font-weight-bold">Image</th>
                      <th scope="col" class="font-weight-bold">Item Name</th>
                      <th scope="col" class="font-weight-bold">Price</th>
                      <th scope="col" class="font-weight-bold">Category</th>
                      <th scope="col" class="font-weight-bold">Supplier</th>
                      <th scope="col" class="font-weight-bold">Time Created</th>
                      <th scope="col" class="font-weight-bold">Time Updated</th>
                      <th scope="col" class="font-weight-bold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td><img src="{{$item->img}}" class="img-thumbnail" width="100" height="100" ></td>
                        <td>{{$item->item_name}}</td>
                        <td>{{$item->sellprice}}</td>
                        <td>{{$item->category_name}}</td>
                        <td>{{$item->sup_name}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>{{$item->updated_at}}</td>
                        <td>
                        <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 12px; padding: 4px 8px; background-color: #696cff; border-color: #696cff;">
        <i class="fas fa-ellipsis-v fa-lg"></i>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 100px;">
        <a class="dropdown-item" href="{{route('items.edit',$item->it_id)}}"><i class="fas fa-edit fa-lg" style="color: #FFAE42;"></i> Edit</a>
        <form style="margin-bottom: 0;" action="{{route('items.destroy',$item->it_id)}}" method="POST">
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
