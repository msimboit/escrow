$('#change').change(function(){
    //this is just getting the value that is selected
    var title = 'Enter Your Business Name: ';
    $('.modal-title').html(title);
    if($(this).val() == 'vendor'){
        $('.modal').modal('show');
        $('#modal_save').click( function (){
            var modal_business_name = $('#modal_business_name').val();
            $('#business_name').val(modal_business_name);
        })
    }
    if($(this).val() == 'buyer'){
        var buyer = 'buyer'
        $('#business_name').val(buyer);
    }
});



$( ".number" ).on( "click", function() {
    if($( ".number:checked" ).length == 1)
        {
            $('#reg').prop('disabled', false);
        }
    else
        {
            $('#reg').prop('disabled', true);
        }  
});