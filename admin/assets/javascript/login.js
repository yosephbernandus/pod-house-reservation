function nyandaBisaKlik(a) {
	$(a).click(function(e) {
	    e.stopPropagation();
	    e.preventDefault();
	    e.stopImmediatePropagation();

	    return false;
	});

	$(a).bind('contextmenu', function(e) {
	    e.stopPropagation();
	    e.preventDefault();
	    e.stopImmediatePropagation();
	    return false;
	});
}

function bisaKlik(a) {
	$(a).unbind('click');
	$(a).unbind('contextmenu');
}

$(document).ready(function(){
	$('#form_login').on('submit', function(e){
		e.preventDefault();

		var datastring = $(this).serialize();
		var target = $(this).attr('action');
		
		preloader('show');

		$.ajax({
			type: "POST",
			url: target,
			data: datastring,
			dataType: 'json',
			headers: {
				"Access-Control-Allow-Origin": siteUrl
			},
			error: function(){
				preloader('hide');
				$('#modalAlert-title').html('Error');
				$('#modalAlert-body').html('Failed to logged in. Server refused to connect.');
				$('#modalAlert-footer').html('<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>');
				$('#modalAlert').modal('show');
				
				return;
			},
			success: function(data) {
				if (data.success == false) {
					preloader('hide');
					$('#modalAlert-title').html('Warning');
					$('#modalAlert-body').html(data.message);
					$('#modalAlert-footer').html('<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>');
					$('#modalAlert').modal('show');
					
					return;
				}
				else {
					window.location = data.redirect;
				}
				
			},
			timeout: 3000
		});
	});
})