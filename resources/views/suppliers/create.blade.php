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
    <h4 class="fw-bold py-3 mb-4">Suppliers <span class="text-muted fw-light">/ Create</span></h4>

        <div class="card">
        <div class="card-body">
        <form action="{{route('suppliers.store')}}"  method="POST" enctype="multipart/form-data">
        @csrf
       
        <div class="form-group row">
            <label for="name">Supplier Name</label>
            <input type="text" class="form-control" id="sup_name" name="sup_name" placeholder="Enter Supplier Name" onfocus="clearPlaceholder()" onblur="restorePlaceholder()">

        </div>
        <div class="form-group row">
            <label for="name">Supplier Contact</label>
            <input type="text" class="form-control" id="sup_contact" name="sup_contact" placeholder="Enter Supplier Contact Number" onfocus="clearPlaceholder()" onblur="restorePlaceholder()">
        
            <div class="form-group row">
                <label for="name">Supplier Address</label>
                <input type="text" class="form-control" id="sup_address" name="sup_address" placeholder="Enter Supplier Address" onfocus="clearPlaceholder()" onblur="restorePlaceholder()">
            </div>

            <div class="form-group row">
                <label for="name">Supplier Email</label>
                <input type="text" class="form-control" id="sup_email" name="sup_email" placeholder="Enter Supplier Email" onfocus="clearPlaceholder()" onblur="restorePlaceholder()">
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
    var input = document.getElementById('sup_name');
    input.placeholder = '';
  }

  function restorePlaceholder() {
    var input = document.getElementById('sup_name');
    input.placeholder = 'Enter Data';
  }
</script>

@endsection