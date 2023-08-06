@extends('layouts.admindashboard')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="fw-bold py-3 mb-4">Data Tables <span class="text-muted fw-light">/ Stocks</span></h4> <!--Change "Payment Methods" -->
    <div class="card">
        <div class="card-body">   
    <div class="row">
        <div class="col-12 table-responsive">
        <div align="left">
            <button type="button" name="create_record" id="create_record" class="btn btn-primary btn-lg float-start" style="margin-right: 15px;">Create New</button>
            <a href="{{url('stocks/export')}}" name="excel" id="excel" class="btn btn-outline-secondary" style="margin-top: 6px;"><span class="tf-icons bx bx-grid"></span> Export Excel</a>
        </div>
        <br>

            <table class="table table-striped table-bordered stocks_datatable"> <!--Change "payment_methods_datatable" -->
                <thead>
                    <tr> <!--Change to desired datas to display-->
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Quantity</th>
                        <th width="180px">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
 
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
        @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Add New Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group1">
                <label>Product : </label>
                    <select class="form-select" id="exampleFormControlSelect1" >
                        <option value="0" disabled selected style="display: none;">Open this select menu</option>
                        @foreach($items as $item)
                            <option value="{{$item->id}}">{{$item->id}} - {{$item->item_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Quantity : </label>
                    <input type="text" name="quantity" id="quantity" class="form-control" />
                </div>
                <input type="hidden" name="action" id="action" value="Add" />
                <input type="hidden" name="hidden_id" id="hidden_id" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <input type="submit" name="action_button" id="action_button" value="Add" class="btn btn-primary" />
            </div>
        </form>  
        </div>
        </div>
    </div>
 
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <form method="post" id="sample_form" class="form-horizontal">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Delete</button>
            </div>
        </form>  
        </div>
        </div>
    </div>
 
</div>
</div>
</div>
</div>
</body>
<!-- Script for select form -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var selectMenu = document.getElementById("exampleFormControlSelect1");
        selectMenu.addEventListener("change", function() {
            var selectedValue = selectMenu.value;
            if (selectedValue === "0") {
                selectMenu.selectedIndex = -1;
            }
        });
    });
</script>
<script type="text/javascript">
    var table;
    $(document).ready(function() {
    table = $('.stocks_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('stocks.datatable') }}",
        columns: [
            {data: 'id', name: 'items.id'},
            {data: 'item_name', name: 'item_name'},
            {data: 'img_path', name: 'img_path', render: function(data, type, full, meta) {
                    if (type === 'display' && data) {
                        return '<img src="' + '{{ url('/') }}/' + data + '" class="img-thumbnail" width="100" height="100" />';
                    } else {
                        return data;
                    }
                }
            },
            {data: 'quantity', name: 'quantity'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    $('#create_record').click(function(){
        $('.modal-title').text('Add New Record');
        $('#action_button').val('Add');
        $('#action').val('Add');
        $('#form_result').html('');
        $('#sample_form')[0].reset();
        $('.form-group1').show();
        $('#formModal').modal('show');
    });
    });
    $('#sample_form').on('submit', function(event){
        event.preventDefault(); 
        var action_url = '';

        if($('#action').val() == 'Add')
        {
            action_url = "{{ route('stocks.store2') }}";
        }

        if($('#action').val() == 'Edit')
        {
            action_url = "{{ route('stocks.update2') }}";
        }

        // Get the selected item ID from the dropdown
        var selectedItemID = $('#exampleFormControlSelect1').val();

        // Create the FormData object
        var formData = new FormData($('#sample_form')[0]);
        formData.append('id', selectedItemID); // Append the selected item ID
        $.ajax({
            type: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: action_url,
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,

            success: function(data) {
                console.log('success: '+data);
                var html = '';
                // $('#formModal').modal('hide');
                $('#sample_form')[0].reset();
                table.ajax.reload(null, false);

                if(data.errors)
                {
                    html = '<div class="alert alert-danger">';
                    for(var count = 0; count < data.errors.length; count++)
                    {
                        html += '<p>' + data.errors[count] + '</p>';
                    }
                    html += '</div>';
                }
                if(data.success)
                {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    $('#sample_form')[0].reset();
                    $('#stock_datatable').DataTable().ajax.reload(null, false);
                }
                $('#form_result').html(html);
            },
            error: function(data) {
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
        
    });
    $(document).on('click', '.edit', function(event){
        event.preventDefault(); 
        var id  = $(this).attr('id'); //alert(id );
        console.log('item_id : ', id );
        $('#form_result').html('');

        $.ajax({
            url: "/stocks/datatables/edit/" + id + "/",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: "json",
            success: function(data) {
                console.log('success: ' + data);
                // console.log('item_id : ', data.result.id );
                console.log('quantity: ', data.result.quantity);
                $('#quantity').val(data.result.quantity);
                $('#hidden_id').val(id);
                $('.modal-title').text('Edit Record');
                $('#action_button').val('Update');
                $('#action').val('Edit'); 
                $('.form-group1').hide();
                $('#formModal').modal('show');
            },
        error: function(data) {
            var errors = data.responseJSON;
            console.log(errors);
        }
    });
});

    var methods_id;
 
    $(document).on('click', '.delete', function(){
        methods_id = $(this).attr('id');
        $('#confirmModal').modal('show');
    });

    $('#ok_button').click(function(){
        $.ajax({
            url:"/stocks/datatables/destroy/"+methods_id,
            beforeSend:function(){
                $('#ok_button').text('Deleting...');
            },
            success:function(data)
            {
                setTimeout(function(){
                $('#confirmModal').modal('hide');
                $('#category_datatable').DataTable().ajax.reload();
                //alert('Data Deleted');
                $('#sample_form')[0].reset();
                table.ajax.reload(null, false);
                }, 2000);
            }
        })
    });

</script>
@endsection