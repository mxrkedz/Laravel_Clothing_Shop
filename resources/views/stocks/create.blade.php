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
    <h4 class="fw-bold py-3 mb-4">Stocks <span class="text-muted fw-light">/ Create</span></h4>

        <div class="card">
        <div class="card-body">
            <form action="{{url('/stocks')}}"  method="POST" enctype="multipart/form-data">
                @csrf
               
                <div class="form-group row">
                  <label for="country">Item</label>
                  <select class="form-select form-control" name="item_id">
                    <option selected>Select Item</option>
                      @foreach($items as $item)
                        <option value={{$item->id}}>{{$item->item_name}}</option>
                      @endforeach
                  </select>
                </div>
        
                <div class="form-group row">
                    <label for="name">Quantity</label>
                    <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity" onfocus="clearPlaceholder()" onblur="restorePlaceholder()">
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
    var input = document.getElementById('quantity');
    input.placeholder = '';
  }

  function restorePlaceholder() {
    var input = document.getElementById('quantity');
    input.placeholder = 'Enter Quantity';
  }
</script>

@endsection