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

function hanyaAngka(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}

$(document).ready(function(){
	
	$("form[name='form_room_add']").submit(function(e){
		e.preventDefault();

		var datastring = $(this).serialize();
		var target = $(this).attr('action');

		preloader('show');

		$.ajax({
			type: 'POST',
			url: target,
			data: datastring,
			dataType: 'json',
			success: function(data){
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

	$('#form_room_edit').submit(function(e){
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

	var t = $('#room').DataTable( {
		"ajax": site_url + "room/data",
		"order": [[ 2, 'desc']],
		"columns": [
		{"data": "id"},
		{"data": "image"},
		{"data": "nama_room"},
		{"data": "jumlah_room"},
		{"data": "harga"},
		{"data": "diskon"},
		{"data": "breakfast"},
		{"data": "aksi"},
		]
	});

	t.on( 'order.dt search.dt', function () {
		t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
})