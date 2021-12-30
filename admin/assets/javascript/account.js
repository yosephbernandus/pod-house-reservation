function hanyaAngka(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

$(document).ready(function(){
    
    $('#form_user_edit').submit(function(e){
        e.preventDefault();

        var datastring = $(this).serialize();
        var target = $(this).attr('action');

        preloader('show');

        $.ajax({
            type: 'POST',
            url: target,
            data: datastring,
            dataType: 'json',
            success: function(data) {
                if (data.success === false) {
                    preloader('hide');

                    $('#modalAlert-title').html('Warning');
                    $('#modalAlert-body').html(data.message);
                    $('#modalAlert-footer').html('<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>');
                    $('#modalAlert').modal('show');

                    return;
                }
                else {
                    preloader('hide');

                    $('#modalAlert-title').html('Success');
                    $('#modalAlert-body').html(data.message);
                    $('#modalAlert-footer').html('<button id="btn-go" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>');
                    $('#modalAlert').modal('show');

                    $('#btn-go').click(function(e){
                        e.preventDefault();
                        window.location = data.redirect;
                    });
                }
            }
        })
    })
})