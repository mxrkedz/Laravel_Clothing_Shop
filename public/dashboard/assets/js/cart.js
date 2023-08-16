$(document).ready(function(){
    $('.addToCartBtn').click(function (e) {
        e.preventDefault();

        var item_id = $(this).closest('.item_data').find('.item_id').val();
        var quantity = $(this).closest('.item_data').find('.qty-input').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: "POST",
            url: "/add-to-cart",
            data: {
                'item_id': item_id,
                'quantity': quantity,
            },
            success: function(response) {
                swal(response.status);
            }
        });
    });

    $('.increment-btn').click(function (e) {
        e.preventDefault();

        var inc_value = $(this).closest('.item_data').find('.qty-input').val();
        var item_id = $(this).closest('.item_data').find('.item_id').val();
        
        var value = parseInt(inc_value, 10);
        value = isNaN(value) ? 0 : value;
        if(value < 10)
        {
            value++;
            $(this).closest('.item_data').find('.qty-input').val(value);
            updateQuantityOnServer(item_id, value); // Call here
        }
    });

    $('.decrement-btn').click(function (e) {
        e.preventDefault();

        var dec_value = $(this).closest('.item_data').find('.qty-input').val();
        var item_id = $(this).closest('.item_data').find('.item_id').val();
        var value = parseInt(dec_value, 10);
        value = isNaN(value) ? 0 : value;
        if(value > 1)
        {
            value--;
            $(this).closest('.item_data').find('.qty-input').val(value);
            updateQuantityOnServer(item_id, value); // Call here
        }
    });

    $('.delete-cart-item').click(function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var item_id = $(this).closest('.item_data').find('.item_id').val();
        $.ajax({
            method:"POST",
            url:"delete-cart-item",
            data:{
                'item_id':item_id,
            },
            dataType:"",
            success: function (response){
                window.location.reload();
                swal("",response.status, "success");
            }
        });
    });

    function updateQuantityOnServer(item_id, new_quantity) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: "POST",
            url: "/update-cart",
            data: {
                'item_id': item_id,
                'quantity': new_quantity,
            },
            success: function(response) {
                // Handle the server response if needed
            }
        });
    }
});
