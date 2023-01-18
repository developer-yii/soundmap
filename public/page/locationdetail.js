$(document).ready(function() {
    var msgElement = $('#add_error_message');
    var editmsgElement = $('#edit_error_message');
   
   CKEDITOR.replace( 'description', {
        
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