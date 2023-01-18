$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': _token
    }
});
if($('.model-select2').length>0)
{
    $('.model-select2').select2();   
}
if($('.custom-select2').length>0)
{
    $('.custom-select2').select2();   
}

$(window).on('hidden.bs.modal', function() {  
    $('.modal').find("input[type=text], textarea").val("");
    $('.modal').find("select").val("");
    $('.modal').find("#checklist_type").val("1");
    $('.model-select2').val('').trigger('change');
});

$('.add-new-button').click(function(){
    $('.modal-lable-class').html('Add');
})




var click_proc_id = 0;
$('body').on('click','.view-procedure-notification',function(event) {
    click_proc_id = $(this).attr('data-id');
    $this = $(this);
    $.ajax({
        url: viewdetailUrl+'?id='+click_proc_id+'&field=is_read',
        type: 'GET',
        dataType: 'json',
        success: function(result) {
            $('#detail-modal').modal('show');
            $('#detail-modal .procedure-name').html(result.data.title);
            $('#detail-modal .procedure-desc').html(result.data.description);
            if(isStaff)
            $('.accept-procedure').removeClass('hidden');
        }
    });    
});

$('body').on('click','.task-activity-link',function(event) {
    let task_id = $(this).attr('data-id');
    let user_id = $(this).attr('data-user-id');
    if(typeof user_id=="undefined")
        user_id = 0;
    if(typeof task_id=="undefined")
        task_id = 0;

    let dayname = "";
    if($('#week_days').length && $('#week_number').length)
    {
        dayname += $('#week_days').val();
        dayname += $('#week_number').val();    
    }

    $this = $(this);
    $('#task-activity-modal').modal('show');
    $.ajax({
        url: activityUrl+'?task_id='+task_id+'&user_id='+user_id+'&dayname='+dayname,
        type: 'GET',
        beforeSend: function() {
            $('.task-activity-div').html('<div class="spinner-border text-success" role="status"></div>');
        },
        success: function(result) {
            $('.task-activity-div').html(result);
        }
    });    
});




$('.accept-procedure').click(function(){
    
    $this = $(this);
    $.ajax({
        url: viewdetailUrl+'?id='+click_proc_id+'&field=is_accepted',
        type: 'GET',
        dataType: 'json',
        success: function(result) {
            getnotifications();
            $('#detail-modal').modal('hide');
        }
    });    
})

$('body').on('click','.status-accepted',function(event) {
    getnotifications();
});

$('.clear-all').click(function(){
    
    $this = $(this);
    if(confirm("Are you sure want to clear all notification?"))
    {
        $.ajax({
            url: urlclearnotification,
            type: 'GET',
            success: function(result) {
                getnotifications();
            }
        });     
    }
})

// setInterval(function(){
//     getnotifications();
// },5000)

$('#show-table-button').click(function(){
    $('.table-button').toggleClass('hidden');
})