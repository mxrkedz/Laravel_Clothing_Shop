@extends('layouts.admindashboard')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y"> 
<h4 class="fw-bold py-3 mb-4">Items <span class="text-muted fw-light">/ Edit</span></h4>
        <div class="card">
        <div class="card-body">
        <form action="{{route('items.update', $item->it_id)}}"  method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        
        <div class="form-group row">
          <label for="method_name">Item Name</label>
          <input type="text" class="form-control" id="item_name"  name="item_name" placeholder="" value="{{$item->item_name}}">
        </div>
        <div class="form-group row">
          <label for="method_name">Sell Price</label>
          <input type="text" class="form-control" id="sellprice"  name="sellprice" placeholder="" value="{{$item->sellprice}}">
        </div>
      <div class="form-group row">
        <label for="sup_id">Supplier</label>
        <select class="form-select form-control @error('sup_id') is-invalid @enderror" name="sup_id">
            <option selected value="{{ old('sup_id', $item->sup_id) }}">{{ $item->sup_name }}</option>
            @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->sup_name }}</option>
            @endforeach
        </select>
        @error('sup_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group row">
        <label for="cat_id">Category</label>
        <select class="form-select form-control @error('cat_id') is-invalid @enderror" name="cat_id">
            <option selected value="{{ old('cat_id', $item->cat_id) }}">{{ $item->category_name }}</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
            @endforeach
        </select>
        @error('cat_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
          <label>Upload Image : </label>
          <input type="file" name="img_path" accept='image/*' class="form-control">
    </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection