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
    <h4 class="fw-bold py-3 mb-4">Payment Method <span class="text-muted fw-light">/ Create</span></h4>

        <div class="card">
        <div class="card-body">
        <form action="{{route('paymentmethods.store')}}"  method="POST" enctype="multipart/form-data">
        @csrf
       
        <div class="form-group row">
            <label for="name">Method Name</label>
            <input type="text" class="form-control" id="method_name" name="methods" placeholder="Enter Method Name" onfocus="clearPlaceholder()" onblur="restorePlaceholder()">

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
    var input = document.getElementById('method_name');
    input.placeholder = '';
  }

  function restorePlaceholder() {
    var input = document.getElementById('method_name');
    input.placeholder = 'Enter Method Name';
  }
</script>

@endsection