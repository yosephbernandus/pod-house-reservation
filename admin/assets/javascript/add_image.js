Dropzone.autoDiscover = false;

$(document).ready(function () {

	$("#form_image_upload").dropzone({
		url: $(this).attr('action'),
		paramName: "image",
		addRemoveLinks: true,
		filesizeBase: 1024,
		maxFilesize: 10,
		acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
		dictDefaultMessage: 'Drop images here or Click here to upload',
		queuecomplete: function (file, response) {
			window.location = siteUrl + 'media';
		},
		error: function (file, response) {
			$('#modalAlert-title').html('Failed');
			$('#modalAlert-body').html(response);
			$('#modalAlert-footer').html('<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>');
			$('#modalAlert').modal('show');
		}
	});

});