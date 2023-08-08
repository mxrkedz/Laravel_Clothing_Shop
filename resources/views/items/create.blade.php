@extends('layouts.admindashboard')
@section('content')
@if ($errors->any())

    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="container-xxl flex-grow-1 container-p-y"> 
    <h4 class="fw-bold py-3 mb-4">Items <span class="text-muted fw-light">/ Create</span></h4>

        <div class="card">
        <div class="card-body">
        <form action="{{route('items.store')}}"  method="POST" enctype="multipart/form-data">
        @csrf
       
        <div class="form-group row">
            <label for="name">Item Name</label>
            <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Enter Item Name" onfocus="clearPlaceholder()" onblur="restorePlaceholder()">

        </div>
        <div class="form-group row">
            <label for="name">Sell Price</label>
            <input type="text" class="form-control" id="sellprice" name="sellprice" placeholder="Enter Sell Price" onfocus="clearPlaceholder()" onblur="restorePlaceholder()">

            <div class="form-group row">
                <label for="country">Supplier</label>
                <select class="form-select form-control" name="sup_id" required>
                    <option selected>Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value={{$supplier->id}}>{{$supplier->sup_name}}</option>
                    @endforeach
                </select>
                @error('sup_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group row">
                <label for="country">Category</label>
                <select class="form-select form-control" name="cat_id" required>
                    <option selected>Select Item Category</option>
                    @foreach($categories as $category)
                        <option value={{$category->id}}>{{$category->category_name}}</option>
                    @endforeach
                </select>
                @error('cat_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Upload Image : </label>
                <input type="file" name="img_path" accept='image/*' class="form-control">
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-primary float-left">Submit</button>
        </div>

    </form>
</div>
</div>
</div>
</div>

<script>
  function clearPlaceholder() {
    var input = document.getElementById('item_name');
    input.placeholder = '';
  }

  function restorePlaceholder() {
    var input = document.getElementById('item_name');
    input.placeholder = 'Enter Item Name';
  }
</script>

@endsection