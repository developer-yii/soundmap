$(document).ready(function() {
    var msgElement = $('#add_error_message');
    var editmsgElement = $('#edit_error_message');
   
   CKEDITOR.replace( 'description', {
        
    });

     $('#create_location_form').submit(function(event) {   
        event.preventDefault();
        // event.stopImmediatePropagation();
        $('.error').html("");
        $('#create_location_form .error').show();

        var message = CKEDITOR.instances['description'].getData();
        $('#description').val(message);

        var $this = $(this);
        var insert = new FormData($('#create_location_form')[0]);
        $.ajax({
            url:createlocationUrl,
            type: 'POST',
            data: insert,
            dataType: 'json',
            contentType: false,
            processData: false,
            cache : false,
            async : false,
            beforeSend: function() {
                $($this).find('button[type="submit"]').prop('disabled', true);
            },
            success: function(result) {
                $($this).find('button[type="submit"]').prop('disabled', false);
                if (result.status == true) {
                    $this[0].reset();
                    element = $('#flash-message');
                    showFlash(element, result.message, 'success');
                    window.location.href=result.data;
                    $('.error').html("");
                } else {
                   
                   first_input = "";
                    $('.error').html("");
                    $.each(result.error, function(key)
                        {
                        if(first_input=="") first_input=key;
                        $('#create_location_form .error-'+key).html(result.error[key]);  

                    });
                    $('#create_location_form').find("."+first_input).focus(); 
                  }
            },
            error: function(error) {
                $($this).find('button[type="submit"]').prop('disabled', false);
                alert('Something went wrong!', 'error');
            }
        });
    }); 


    $('#edit_location_form').submit(function(event) {   
        event.preventDefault();
        // event.stopImmediatePropagation();
        $('.error').html("");
        $('#edit_location_form .error').show();

        var message = CKEDITOR.instances['description'].getData();
        $('#description').val(message);

        var $this = $(this);
        var insert = new FormData($('#edit_location_form')[0]);
        $.ajax({
            url:updatelocationUrl,
            type: 'POST',
            data: insert,
            dataType: 'json',
            contentType: false,
            processData: false,
            cache : false,
            async : false,
            beforeSend: function() {
                $($this).find('button[type="submit"]').prop('disabled', true);
            },
            success: function(result) {
                $($this).find('button[type="submit"]').prop('disabled', false);
                if (result.status == true) {
                    $this[0].reset();
                    element = $('#flash-message');
                    showFlash(element, result.message, 'success');
                    window.location.href=result.data;
                    $('.error').html("");
                } else {
                   
                   first_input = "";
                    $('.error').html("");
                    $.each(result.error, function(key)
                        {
                        if(first_input=="") first_input=key;
                        $('#edit_location_form .error-'+key).html(result.error[key]);  

                    });
                    $('#edit_location_form').find("."+first_input).focus(); 
                  }
            },
            error: function(error) {
                $($this).find('button[type="submit"]').prop('disabled', false);
                alert('Something went wrong!', 'error');
            }
        });
    }); 


    $('.delete-img').on('click',function(e){
    var $this = $(this);
    var imgval =$(this).attr('value');
    var id=$(this).attr('data-id');
    var url = deleteimgurl;
    url = url.replace(':id', id);
    if(confirm('Are you sure want to delete?')){

                $.ajax({
                    url: url,
                    type: 'POST',
                    data:{
                        imgval:imgval,
                        id:id,
                    },
                    success: function(result) {

                        element = $('#flash-message');
                        showFlash(element, result.message, 'success');
                        $this.closest('.delimg').remove();

                    }
                });
            }
  });
 

    $('body').on('click','.delete-location',function(event) {
        var id = $(this).attr('delete-id');
        if(confirm('Are you sure want to delete?')){
            $.ajax({
                url: deleteUrl+'?id='+id,
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    element = $('#flash-message');
                    showFlash(element, result.message, 'success');
                    $('#location').DataTable().ajax.reload();
                }
            });    
        }
    });

    var location = $('#location').DataTable({
        processing: true,
        serverSide: true,
        responsive:true,
        "stripeClasses": [],
        ajax: {
            url: apiUrl,
            type: 'GET',
            headers: {
                'X-XSRF-TOKEN': $('meta[name=csrf-token]').attr('content'),
            },
        },
        columns: [
        { data: 'location_name' },
        { data: 'latitude' },
        { data: 'longitude' },
        { data: 'description' },
        {
            searchable:false,
            orderable:false,
            data:'id',
            name:'id',
            render: function(_,_, full) {
                var contactId = full['id'];
                if(contactId){
                    actions = '<td><a href="'+location_editurl+'?id='+contactId+'" edit-id="'+ contactId +'" class="action-icon edit-user"><i class="mdi mdi-square-edit-outline"></i></a>';
                    actions += '<a href="javascript:void(0);" delete-id="'+ contactId +'" class="action-icon delete-location"><i class="mdi mdi-delete"></i></a></td>';
                    return actions;
                }
                return "";
            }
        },
        ],
    });

    $('#filter-group').change(function(){
        location.draw();
    });
});