@extends('layouts.admindashboard')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y"> 
<h4 class="fw-bold py-3 mb-4">Shippers <span class="text-muted fw-light">/ Edit</span></h4>
        <div class="card">
        <div class="card-body">
        <form action="{{route('shippers.update', $items->id)}}"  method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        
        <div class="form-group row">
          <label for="method_name">Shipper Name</label>
          <input type="text" class="form-control" id="ship_name"  name="ship_name" placeholder="" value="{{$shippers->ship_name}}">
        </div>

        <div class="form-group">
          <label>Upload Image : </label>
          <input type="file" name="img_path" accept='image/*' class="form-control">
      </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection