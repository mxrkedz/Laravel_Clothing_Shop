@extends('layouts.admindashboard')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y"> 
<h4 class="fw-bold py-3 mb-4">Stocks <span class="text-muted fw-light">/ Edit</span></h4>
        <div class="card">
        <div class="card-body">
        <form action="{{route('stocks.update', $stock->item_id)}}"  method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        
        <div class="form-group row">
                                  
          <label for="country">Item</label>
          <select class="form-select form-control" name="item_id">
          <option selected value="{{$stock->item_id}}">{{$stock->item_name}}</option>
          @foreach($items as $item)
          <option value={{$item->id}}>{{$item->item_name}}</option>
        @endforeach
    </select>
  </div>

        <div class="form-group row">
          <label for="category_name">Quantity</label>
          <input type="text" class="form-control" id="quantity"  name="quantity" placeholder="" value="{{$stock->quantity}}">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection