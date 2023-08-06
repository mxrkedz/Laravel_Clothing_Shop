@extends('layouts.admindashboard')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y"> 
<h4 class="fw-bold py-3 mb-4">Suppliers <span class="text-muted fw-light">/ Edit</span></h4>
        <div class="card">
        <div class="card-body">
        <form action="{{route('suppliers.update', $suppliers->id)}}"  method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        
        <div class="form-group row">
          <label for="method_name">Supplier Name</label>
          <input type="text" class="form-control" id="sup_name"  name="sup_name" placeholder="" value="{{$suppliers->sup_name}}">
        </div>

        <div class="form-group row">
          <label for="method_name">Supplier Contact</label>
          <input type="text" class="form-control" id="sup_contact"  name="sup_contact" placeholder="" value="{{$suppliers->sup_contact}}">
        </div>

        <div class="form-group row">
          <label for="method_name">Supplier Address</label>
          <input type="text" class="form-control" id="sup_address"  name="sup_address" placeholder="" value="{{$suppliers->sup_address}}">
        </div>

        <div class="form-group row">
          <label for="method_name">Supplier Email</label>
          <input type="text" class="form-control" id="sup_email"  name="sup_email" placeholder="" value="{{$suppliers->sup_email}}">
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