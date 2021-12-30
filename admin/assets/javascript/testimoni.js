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
	$('#form_testimoni_edit').on('submit', function(e) {
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
		});
	});

	var t = $('#testimoni').DataTable( {
		"ajax": site_url + "testimoni/data",
		"order": [[ 2, 'desc']],
		"columns": [
		{"data": "id"},
		{"data": "id_reservasi"},
		{"data": "nama"},
		{"data": "email"},
		{"data": "pesan"},
		{"data": "company"},
		{"data": "rating"},
		{"data": "status"},
		{"data": "aksi"},
		]
	});

	t.on( 'order.dt search.dt', function () {
		t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
})

