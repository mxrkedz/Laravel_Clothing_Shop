@extends('layouts.admindashboard')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y"> 
<h4 class="fw-bold py-3 mb-4">Category <span class="text-muted fw-light">/ Edit</span></h4>
        <div class="card">
        <div class="card-body">
        <form action="{{route('category.update', $categories->id)}}"  method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        
        <div class="form-group row">
          <label for="category_name">Category Name</label>
          <input type="text" class="form-control" id="category_name"  name="category_name" placeholder="" value="{{$categories->category_name}}">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection