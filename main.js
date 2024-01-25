/**
 * Ajax to handle task submission.
 */
jQuery(document).ready(function($){
    $(document).on('submit', '#input_form', function (e) {                 
        e.preventDefault();

        formData = $(this).serializeArray();
        formData.push({ name: "action", value: "save" });
        $('.alert.alert-error').remove();
        $.ajax({
            type:"POST",
            url:"./ajax.php",
            data: formData,
        }).then(
            function(response){
                console.log(response);
                //check to see that the item was added to DB
                if(response === "success"){
                   location.replace("index.php");
                }else{
                    $('.action-message').append('<div class="alert alert-error">' + response + '</div>');
                }

            }
            ,
            function(){
                $('.action-message').html('<div class="alert alert-error>ERROR:Ajax not executed</div>');
            }
        );
        
    });    
    /**
     * Ajax to handle task deletion.
     */
    $(document).on('click','.delIcon', function(){
        let field = $(this).closest('.checkboxes');
        let data = {
            'action': 'delete',
            'id': field.find('input[type="checkbox"]').val(),
        }
        $.ajax({
            type:"POST",
            url:"./ajax.php",
            data: data,
        }).then(
            function(response){
                //check to see that the item was added to DB
                if(response === "success"){
                    field.remove();
                    $('.action-message').append('<div class="alert alert-success">Task has been successfully deleted</div>');
                }else{
                    $('.action-message').append('<div class="alert alert-error">' + response + '</div>');
                }

            }
            ,
            function(){
                $('.action-message').html('<div class="alert alert-error>ERROR:Ajax not executed</div>');
            }
        );
        
    });

    /**
     * Open task edit form
     */
    $(document).on('click','.editIcon', function(){
        let parent= $(this).closest('.checkboxes');
        $('.edit').removeClass('active');
        $('.list-item').removeClass('inactive');
        parent.find('.list-item').addClass('inactive');
        parent.find('.edit').addClass('active');
    });

    /**
     * Close task edit form
     */
    $(document).on('click','.close-edit', function(){
        let parent= $(this).closest('.checkboxes');
        parent.find('.list-item').removeClass('inactive');
        parent.find('.edit').removeClass('active');
    });

    /**
     * Ajax to update a task edit.
     */
    $(document).on('click','.update-task', function(e){
        e.preventDefault();
        let id= $(this).closest('.edit').attr('id');
        let data = {
            task: {
                id: $("[name='id-" + id + "']").val(),
                title: $("[name='title-" + id + "']").val(),
                date: $("[name='date-" + id + "']").val(),
            },
            action:"update" 
        };
        $.ajax({
            type:"POST",
            url:"./ajax.php",
            data: data,
        }).then(
            function(response){
                //check to see that the item was added to DB
                if(response === "success"){
                    location.replace("index.php");
                    parent.find('.list-item').removeClass('inactive');
                    parent.find('.edit').removeClass('active');
                }else{
                    $('.action-message').append('<div class="alert alert-error">' + response + '</div>');
                }

            }
            ,
            function(){
                $('.action-message').html('<div class="alert alert-error>ERROR:Ajax not executed</div>');
            }
        );

    });

    /**
     * Ajax to mark task as done.
     */
    $(document).on('change','.task-checkbox', function(e){
        e.preventDefault();
        let status = 0;
        if (e.target.checked) 
        {
            status = 1;
        } 
        let data = {
            'action': 'change-status',
            'id': $(this).val(),
            'status': status
        }
        $.ajax({
            type:"POST",
            url:"./ajax.php",
            data: data,
        }).then(
            function(response){
                //check to see that the item was added to DB
                if(response === "success"){
                    let message = 'Task has been marked as undone';
                    if (e.target.checked) 
                    {
                        message = 'Task has been marked as done';
                    } 
                    $('.action-message').append('<div class="alert alert-success">' + message + '</div>');
                }

            }
            ,
            function(){
                $('.action-message').html('<div class="alert alert-error>ERROR:Ajax not executed</div>');
            }
        );
    });

});