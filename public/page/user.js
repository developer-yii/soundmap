$(document).ready(function() {
    var msgElement = $('#add_error_message');
    var editmsgElement = $('#edit_error_message');
    $('.add-new-button').click(function(e){
        e.preventDefault();
        $('#password_group').show();
        $('.error').html("");
        $('#add-form')[0].reset();
    });
    $('#add-form').submit(function(event) {
        event.preventDefault();
        var $this = $(this);
        $.ajax({
            url: addUserUrl,
            type: 'POST',
            data: $('#add-form').serialize(),
            dataType: 'json',
            beforeSend: function() {
                $('#add-form').find('button[type="submit"]').prop('disabled', true);
            },
            success: function(result) {
                $('#add-form').find('button[type="submit"]').prop('disabled', false);
                $('#edit-id').val(0);
                if (result.status == true) {
                    $this[0].reset();
                    $('#userTable').DataTable().ajax.reload();
                    setTimeout(function() {
                        $('#add-modal').modal('hide');
                        showFlash(msgElement, result.message, 'success');
                    }, 200);
                    $('.error').html("");

                } else {
                    first_input = "";
                    $('.error').html("");
                    $.each(result.message, function(key) {
                        if(first_input=="") first_input=key;
                        if(!key.includes("[]"))
                            $('#'+key).closest('.mb-3').find('.error').html(result.message[key]);
                    });
                    $('#add-form').find("#"+first_input).focus();
                }
            },
        });
    });


    $('body').on('click','.delete-user',function(event) {
        var id = $(this).attr('delete-id');
        if(confirm('Are you sure want to delete?')){
            $.ajax({
                url: deleteUrl+'?id='+id,
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    element = $('#flash-message');
                    showFlash(element, result.message, 'success');
                    $('#userTable').DataTable().ajax.reload();
                }
            });    
        }
    });
    
    $('body').on('click','.edit-user',function(event) {
        var id = $(this).attr('edit-id');
        $('.error').html("");
        $.ajax({
            url: detailUrl+'?id='+id,
            type: 'GET',
            dataType: 'json',
            success: function(result) {
                $('#edit-id').val(id);
                $('#add-modal').modal('show');
                $('#add-form').find('#id').val(id);
                $('#add-form').find('#name').val(result.data.name);
                $('#add-form').find('#email').val(result.data.email);
                $('#add-form').find('#password').val(result.data.password);
                $('#add-form').find('#password_group').hide();
                $('#add-form').find('#user_type').val(result.data.user_type);
                $('.modal-lable-class').html('Edit');
            }
        });    
    });

    var userTable = $('#userTable').DataTable({
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
        { data: 'name' },
        { data: 'email' },
        {
            searchable:false,
            orderable:false,
            data:'id',
            name:'id',
            render: function(_,_, full) {
                var contactId = full['id'];
                if(contactId){
                    actions = '<td><a href="javascript:void(0);" edit-id="'+ contactId +'" class="action-icon edit-user"><i class="mdi mdi-square-edit-outline"></i></a>';
                    actions += '<a href="javascript:void(0);" delete-id="'+ contactId +'" class="action-icon delete-user"><i class="mdi mdi-delete"></i></a></td>';
                    return actions;
                }
                return "";
            }
        },
        ],
    });

    $('#filter-group').change(function(){
        userTable.draw();
    });
});