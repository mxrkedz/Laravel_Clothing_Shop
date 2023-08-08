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
<h4 class="fw-bold py-3 mb-4">Data Tables <span class="text-muted fw-light">/ Categories</span></h4> <!--Change "Payment Methods" -->
    <div class="card">
        <div class="card-body">   
    <div class="row">
        <div class="col-12 table-responsive">
        <div align="left">
            <button type="button" name="create_record" id="create_record" class="btn btn-primary btn-lg float-start" style="margin-right: 15px;">Create New</button>
            <a href="{{url('category/export')}}" name="excel" id="excel" class="btn btn-outline-secondary" style="margin-top: 6px;"><span class="tf-icons bx bx-grid"></span> Export Excel</a>
            <a href="{{url('category/import')}}" name="excel" id="excel" class="btn btn-outline-secondary" style="margin-top: 6px;"><span class="tf-icons bx bx-grid"></span> Import Excel</a>

        </div>
        <br>
        <form action="{{url('category/import')}}" method="post" enctype="multipart/form-data">
                       @csrf
                       <fieldset>
                           <label>Select File to Upload  <small class="warning text-muted">{{__('Please upload only Excel (.xlsx or .xls) files')}}</small></label>
                           <div class="input-group">
                               <input type="file" required class="form-control" name="uploaded_file" id="uploaded_file">
                               @if ($errors->has('uploaded_file'))
                                   <p class="text-right mb-0">
                                       <small class="danger text-muted" id="file-error">{{ $errors->first('uploaded_file') }}</small>
                                   </p>
                               @endif
                               <div class="input-group-append" id="button-addon2">
                                   <button class="btn btn-primary square" type="submit"><i class="ft-upload mr-1"></i> Upload</button>
                               </div>
                           </div>
                       </fieldset>
                   </form>
            <table class="table table-striped table-bordered category_datatable"> <!--Change "payment_methods_datatable" -->
                <thead>
                    <tr> <!--Change to desired datas to display-->
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
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
        <form method="post" id="sample_form" class="form-horizontal">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Add New Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <div class="form-group">
                    <label>Category : </label>
                    <input type="text" name="category_name" id="category_name" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Upload Image : </label>
                    <input type="file" name="img_path" accept='image/*' class="form-control">
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
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('.category_datatable').DataTable({ //Change ".payment_methods_datatable" depending on the table named on <html>
        processing: true,
        serverSide: true,
        ajax: "{{ route('categorys.datatable') }}", //Change route index
        columns: [
            {data: 'id', name: 'id'},
            {data: 'category_name', name: 'category_name'},
            { data: 'img_path', name: 'img_path', render: function(data, type, full, meta) {
    if (type === 'display' && data) {
        return '<img src="' + '{{ url('/') }}/' + data + '" class="img-thumbnail" width="100" height="100" />';
    } else {
        return data;
    }
}

    },
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    $('#create_record').click(function(){
        $('.modal-title').text('Add New Record');
        $('#action_button').val('Add');
        $('#action').val('Add');
        $('#form_result').html('');
        $('#sample_form')[0].reset();
        $('#formModal').modal('show');
    });

    $('#sample_form').on('submit', function(event){
        event.preventDefault(); 
        var action_url = '';

        if($('#action').val() == 'Add')
        {
            action_url = "{{ route('categorys.store') }}";
        }

        if($('#action').val() == 'Edit')
        {
            action_url = "{{ route('categorys.update') }}";
        }

        var formData = new FormData($('#sample_form')[0]);

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
                    $('#category_datatable').DataTable().ajax.reload(null, false);
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
        var id = $(this).attr('id'); //alert(id);
        $('#form_result').html('');

        $.ajax({
            url :"/category/datatables/edit/"+id+"/", //Change "/paymentmethods/edit/" depending on route"
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType:"json",
            success:function(data)
            {
                console.log('success: '+data);
                $('#category_name').val(data.result.category_name);
                $('#img_path').val(data.result.img_path);
                $('#hidden_id').val(id);
                $('.modal-title').text('Edit Record');
                $('#action_button').val('Update');
                $('#action').val('Edit'); 
                $('#formModal').modal('show');
            },
            error: function(data) {
                var errors = data.responseJSON;
                console.log(errors);
            }
        })
    });
    var methods_id;
 
    $(document).on('click', '.delete', function(){
        methods_id = $(this).attr('id');
        $('#confirmModal').modal('show');
    });

    $('#ok_button').click(function(){
        $.ajax({
            url:"/category/datatables/destroy/"+methods_id,
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
});

</script>
@endsection