$(document).ready(function(){
    var t = $('#guestbook').DataTable( {
        "ajax": site_url + "guestbook/data",
        "order": [[ 2, 'desc']],
        "columns": [
        {"data": "id"},
        {"data": "tanggal"},
        {"data": "nama"},
        {"data": "email"},
        {"data": "telp"},
        {"data": "pesan"},
        {"data": "aksi"},
        {"data": "aksi_email"},
        ]
    });

    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
})