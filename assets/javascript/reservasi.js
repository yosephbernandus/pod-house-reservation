$(function(){
	$('body').on('click', '.delete', function(e){
		e.preventDefault();
		var key = $(this).attr("key-sess");

		swal({
			title: 'Are you sure?',
			text: 'Are you sure to delete from your reservation?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then(function(){
			$.ajax({
				url: site_url + "reservasi/ajax_sess_remove",
				type:"POST",
				data:"key="+key,
				cache:false,
				success:function(html){
					swal({
						title: "Delete",
						text: "Your room has been deleted!",
						type: "success"
					}).then(function(){
						location.reload();
					})
				},
				error: function(xhr, ajaxOptions, thrownError){
					swal({
						title: "Error",
						text: "Cek Your Connection",
						type: "error"
					}).then(function(){
						location.reload();
					});
				}
			})
		})
	})

	$('body').on('submit', 'form[name="validate-date"]',function(e){

		var checkin = $('#datepicker1').val();
		var checkout = $('#datepicker2').val();

		if (checkin == checkout) {
			swal(
				'Warning',
				'Date Cant Not be Same',
				'warning'
				);
			e.preventDefault();
		}

		if (checkout < checkin) {
			swal(
				'Warning',
				'Wrong date',
				'warning'
				);
			e.preventDefault();
		}

		if (checkin > checkout) {
			swal(
				'Warning',
				'Wrong date',
				'warning'
				);
			e.preventDefault();
		}
	})

	$('body').on('submit', 'form[name="reservasi"]',function(e){

		var guest_name = $('input[name="guest_name"]').val();
		var email = $('input[name="email"]').val();
		var telp = $('input[name="telp"]').val();
		var date_now = $('input[name="date_now"]').val();
		var id_reservasi = $('input[name="id_reservasi"]').val();
		var province = $('input[name="province"]').val();
		var country = $('input[name="country"]').val();
		var company = $('input[name="company"]').val();

		e.preventDefault();
		swal({
			title: 'Are You Sure ?',
			text : "Are you sure to save this reservation?",
			type : 'warning',
			showCancelButton : true,
			confirmButtonColor : '#3085d6',
			cancelButtonColor : '#d33',
			confirmButtonText : 'Yes, save it!',
			showLoaderOnConfirm: true,
			preConfirm: function(){
				return new Promise(function(){
					setTimeout(function(){
						$.ajax({
							url: site_url + "reservasi/ajax_simpan_reservasi",
							type:"POST",
							dataType: "json",
							data:"guest_name="+guest_name+"&email="+email+"&telp="+telp+"&date_now="+date_now+"&id_reservasi="+id_reservasi+"&province="+province+"&country="+country+"&company="+company,
							cache:false,
							success:function(data){
								
								var socket = io.connect('http://'+window.location.hostname+':3000');

								socket.emit('new_reservasi_message', {
									new_reservasi_message: data.new_reservasi_message
								});

								socket.emit('new_reservasi', {
									id_reservasi: data.id_reservasi,
									guest_name: data.guest_name,
									email: data.email,
									telp: data.telp,
									id: data.id
								});

								swal({
									title: "Success",
									text: "Your Reservation Success has been saved!, please check your email for see your booking room. Thank You.",
									type:"success"
								}).then(function(){
									location.reload();
								});
							},
							error: function(xhr, ajaxOptions, thrownError){
								swal({
									title: "Error",
									text: "Cek Your Connection",
									type: "error"
								}).then(function(){
									location.reload();
								})
							}
						})
					}, 2000)
				})
			}, allowOutsideClick: false
		})
	})

	$('body').on('submit', 'form[name="checkout"]',function(e){

		e.preventDefault();

		var datastring = $(this).serialize();
		var target = $(this).attr('action');


		swal({
			title: 'Are You Sure ?',
			text : "Are you sure to book this room?",
			type : 'warning',
			showCancelButton : true,
			confirmButtonColor : '#3085d6',
			cancelButtonColor : '#d33',
			confirmButtonText : 'Yes, book it!',
			showLoaderOnConfirm: true,
			preConfirm: function(){
				return new Promise(function(){
					setTimeout(function(){
						$.ajax({
							url: target,
							type:"POST",
							data: datastring,
							cache:false,
							success:function(html){
								swal({
									title: "Success",
									text: "Your room has been saved, click yes for go to reservation form.",
									type:"success"
								}).then(function(){
									window.location.href= site_url + "reservasi/checkout";
								});
							},
							error: function(xhr, ajaxOptions, thrownError){
								swal({
									title: "Error",
									text: "Cek Your Connection",
									type: "error"
								}).then(function(){
									location.reload();
								})
							}
						})
					}, 2000)
				})
			}, allowOutsideClick: false
		})
	})

	$('body').on('submit', 'form[name="contact"]',function(e){

		var nama = $('input[name="nama_contact"]').val();
		var email = $('input[name="email_contact"]').val();
		var telp = $('input[name="telp_contact"]').val();
		var pesan = $('textarea[name="pesan_contact"]').val();
		console.log(pesan);
		e.preventDefault();
		swal({
			title: 'Are You Sure ?',
			text : "send your message?",
			type : 'warning',
			showCancelButton : true,
			confirmButtonColor : '#3085d6',
			cancelButtonColor : '#d33',
			confirmButtonText : 'Yes, send it!',
			showLoaderOnConfirm: true,
			preConfirm: function(){
				return new Promise(function(){
					setTimeout(function(){
						$.ajax({
							url: site_url + "contact/ajax_simpan",
							type:"POST",
							dataType: "json",
							data:"nama="+nama+"&email="+email+"&telp="+telp+"&pesan="+pesan,
							cache:false,
							success:function(data){
								console.log(data);
								var socket = io.connect('http://'+window.location.hostname+':3000');

								socket.emit('new_count_message',  {
									new_count_message: data.new_count_message
								});

								socket.emit('new_message', {
									nama: data.nama,
									email: data.email,
									telp: data.telp,
									pesan: data.pesan,
									id: data.id
								});

								swal({
									title: "Success",
									text: "Thank You, Your message has been send !",
									type:"success"
								}).then(function(){
									location.reload();
								});
							},
							error: function(xhr, ajaxOptions, thrownError){
								swal({
									title: "Error",
									text: "Cek Your Connection",
									type: "error"
								}).then(function(){
									location.reload();
								})
							}
						})
					}, 2000)
				})
			}, allowOutsideClick: false
		})
	})

	$('body').on('submit', 'form[name="testimoni"]',function(e){

		var id_booking = $('input[name="id_booking"]').val();
		var pesan_testimoni = $('textarea[name="pesan_testimoni"]').val();
		var rating = $('select[name="rating"]').val();

		e.preventDefault();
		swal({
			title: 'Are You Sure ?',
			text : "Send Your Testimony?",
			type : 'warning',
			showCancelButton : true,
			confirmButtonColor : '#3085d6',
			cancelButtonColor : '#d33',
			confirmButtonText : 'Yes, send it!',
			showLoaderOnConfirm: true,
			preConfirm: function(){
				return new Promise(function(){
					setTimeout(function(){
						$.ajax({
							url:site_url + "reservasi/ajax_add_testimoni",
							type:"POST",
							data:"id_booking="+id_booking+"&pesan_testimoni="+pesan_testimoni+"&rating="+rating,
							cache:false,
							success:function(html){
								console.log(html);
								if(html.notfound == false)
								{
									swal({
										title: "Error",
										text: "Booking id not found",
										type:"error"
									})
								} else if (html.submitted == false) {
									swal({
										title: "Error",
										text: "Booking id has been submitted",
										type:"error"
									})
								} else if (html.notcheckout == false) {
									swal({
										title: "Error",
										text: "You've never check out, please check out before",
										type:"error"
									})
								} else {
									swal({
										title: "Success",
										text: "Thank You, Your Testimony has been submitted!",
										type:"success"
									}).then(function(){
										location.reload();
									});
								}
							},
							error: function(xhr, ajaxOptions, thrownError){
								swal({
									title: "Error",
									text: "Cek Your Connection",
									type: "error"
								}).then(function(){
									location.reload();
								})
							}
						})
					}, 2000)
				})
			}, allowOutsideClick: false
		})
	})
})