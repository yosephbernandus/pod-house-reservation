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

Dropzone.autoDiscover = false;

var foto_upload = new Dropzone(".dropzone",{
	url: site_url + "gallery/proses_upload",
	maxFilesize: 1,
	method:"post",
	acceptedFiles:"image/*",
	paramName:"userfile",
	dictInvalidFileType:"Invalid Type File",
	addRemoveLinks:true,
});


//Event upload process
foto_upload.on("sending",function(a,b,c){
    a.token=Math.random();
    c.append("token_foto",a.token);
});


//Event remove photo
foto_upload.on("removedfile",function(a){
    var token=a.token;
    $.ajax({
    	type:"post",
      	data:{token:token},
        url: base_url + "gallery/remove_foto",
        cache:false,
        dataType: 'json',
        success: function(){
            console.log("Picture Removed");
        },
        error: function(){
            console.log("Error");
        }
    });
});

$(document).ready(function(){
	var t = $('#gallery').DataTable( {
		"ajax": site_url + "gallery/data",
		"order": [[ 2, 'desc']],
		"columns": [
		{"data": "id"},
		{"data": "nama_foto"},
		{"data": "foto"},
		{"data": "aksi"},
		]
	});

	t.on( 'order.dt search.dt', function () {
		t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
})