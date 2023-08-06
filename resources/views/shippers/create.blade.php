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
    <h4 class="fw-bold py-3 mb-4">Shippers <span class="text-muted fw-light">/ Create</span></h4>

        <div class="card">
        <div class="card-body">
        <form action="{{route('shippers.store')}}"  method="POST" enctype="multipart/form-data">
        @csrf
       
        <div class="form-group row">
            <label for="name">Shipper Name</label>
            <input type="text" class="form-control" id="ship_name" name="ship_name" placeholder="Enter Shipper's Name" onfocus="clearPlaceholder()" onblur="restorePlaceholder()">
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
    var input = document.getElementById('ship_name');
    input.placeholder = '';
  }

  function restorePlaceholder() {
    var input = document.getElementById('ship_name');
    input.placeholder = 'Enter Shipper Name';
  }
</script>

@endsection