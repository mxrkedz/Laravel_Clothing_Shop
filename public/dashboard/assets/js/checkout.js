$(document).ready(function(){
    $('.placeorder_btn').click(function (e){
        e.preventDefault();

        var firstname = $('.firstname').val();
        var lastname = $('.lastname').val();
        var country = $('.country').val();
        var addr1 = $('.addr1').val();
        var addr2 = $('.addr2').val();
        var pcode = $('.pcode').val();
        var towncity = $('.towncity').val();
        var provi = $('.provi').val();
        var phonenum = $('.phonenum').val();
        var emailadd = $('.emailadd').val();

        if(!firstname)
        {
            fname_error = "First name is required";
            $('#fname_error').html('');
            $('#fname_error').html(fname_error);
        }
        else{
            fname_error = "";
            $('#fname_error').html('');
        }

        if(!lastname)
        {
            lastname_error = "Last name is required";
            $('#lastname_error').html('');
            $('#lastname_error').html(lastname_error);
        }
        else{
            lastname_error = "";
            $('#lastname_error').html('');
        }

        if(!country)
        {
            country_error = "Country is required";
            $('#country_error').html('');
            $('#country_error').html(country_error);
        }
        else{
            country_error = "";
            $('#country_error').html('');
        }

        if(!addr1)
        {
            addr1_error = "Address 1 is required";
            $('#addr1_error').html('');
            $('#addr1_error').html(addr1_error);
        }
        else{
            addr1_error = "";
            $('#addr1_error').html('');
        }

        if(!addr2)
        {
            addr2_error = "Address 2 is required";
            $('#addr2_error').html('');
            $('#addr2_error').html(addr2_error);
        }
        else{
            addr2_error = "";
            $('#addr2_error').html('');
        }

        if(!pcode)
        {
            pcode_error = "Postal Code is required";
            $('#pcode_error').html('');
            $('#pcode_error').html(pcode_error);
        }
        else{
            pcode_error = "";
            $('#pcode_error').html('');
        }

        if(!towncity)
        {
            towncity_error = "Town / City is required";
            $('#towncity_error').html('');
            $('#towncity_error').html(towncity_error);
        }
        else{
            towncity_error = "";
            $('#towncity_error').html('');
        }

        if(!provi)
        {
            provi_error = "Province is required";
            $('#provi_error').html('');
            $('#provi_error').html(provi_error);
        }
        else{
            provi_error = "";
            $('#provi_error').html('');
        }

        if(!phonenum)
        {
            phonenum_error = "Phone No. is required";
            $('#phonenum_error').html('');
            $('#phonenum_error').html(phonenum_error);
        }
        else{
            phonenum_error = "";
            $('#phonenum_error').html('');
        }

        if(!emailadd)
        {
            emailadd_error = "Email Address is required";
            $('#emailadd_error').html('');
            $('#emailadd_error').html(emailadd_error);
        }
        else{
            emailadd_error = "";
            $('#emailadd_error').html('');
        }
    });
});